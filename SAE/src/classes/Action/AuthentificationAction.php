<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;
use touiteur\classes\Exceptions\Authentication;
use touiteur\classes\Exceptions\AuthException;
use touiteur\classes\User;

class AuthentificationAction extends Action
{


    public function execute(): string
    {
        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();

        $html = $this->renderAuthentification();

        //On retourne le code HTML
        return  <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li><a href="?action=AuthentificationAction">Connexion</a></li>
                         <li><a href="?action=InscriptionAction">Inscription</a></li>
                     </ul>
                 </div>
                 <div class="deffilementTouite">
                     
                        $html
                     
                 </div>
                 </div>
                 HTML;


    }

    /**
     * fonction qui permet de mettre l'user en session si l'authentification est réussie
     * @param string $email
     * @param string $mdp
     * @return void
     * @throws AuthException
     */
    public static function authenticate(string $email, string $mdp) : void {
        // Connection à la base et récupération du mot de passe haché de l'utilisateur
        $bdd = ConnectionFactory::makeConnection();
        $query = $bdd->prepare('SELECT mdp FROM UTILISATEUR WHERE email = ?');
        $query->bindParam('?',$email);
        $query->execute();

        // Si l'email n'est pas rattaché à aucun mot de passe, l'email est incorrecte ou le compte n'existe pas
        if($query->rowCount() == 0){
            throw new AuthException('E-mail incorrect');
        }

        $passwd = $query->fetch(PDO::FETCH_ASSOC);

        // Vérification de la bonne correspondance du mot de passe sinon on throw AuthException
        if (password_verify($mdp, $passwd['mdp'])) {
            AuthentificationAction::loadProfile($email);
        } else {
            throw new AuthException("Mot de passe saisi incorrect");
        }
    }

    private static function loadProfile(string $email) : void {
        // On se connecte à la base et on sélectionne le nom, prenom et droits de l'email donné
        $bdd = ConnectionFactory::makeConnection();
        $query = $bdd->prepare("SELECT nom,prenom,droits FROM UTILISATEUR WHERE email = ?");
        $query->bindParam('?', $email);
        $query->execute();
        $info = $query->fetch(PDO::FETCH_ASSOC);

        // On crée le nouvel objet User qui sera utilisé le temps de la session
        $user = new User($info['nom'], $info['prenom'], $email, $info['role']);
        $user = serialize($user);
        $_SESSION['user'] = $user;
    }

    private function renderAuthentification() : string {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<END
                <form method='post' action='?action=AuthentificationAction'>
                <h1>Bienvenue sur Touiteur</h1>
                <label>Email : </label><input type='text' name='email'>
                <label>Mot de passe : </label><input type='password' name='mdp'>
                <button type='submit'>Se connecter</button><br><br>
                <a href='?action=InscriptionAction'>Inscrivez vous dès maintenant ici</a>
                </form>
            END;
        }
        else {

            //On vérifie que le mot de passe est assez fort
            if ($this->checkPasswordStrength($_POST['mdp'], 8) === false) {
                return <<<END
                <br>Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial.</br>
                <br><a href='?action=AuthentificationAction'>Retour à la page de connexion</a></br>
                END;
            }

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['mdp'];

            try {
                AuthentificationAction::authenticate($email, $password);
                $user = unserialize($_SESSION['user']);
                var_dump($_SESSION['user']);
                return <<<END
                    <h1>Bienvenue {$user->pseudo}</h1>
                    <a href='?action=logout'>Se déconnecter</a>
                END;
            } catch (AuthException $e) {
                return <<<END
                <br>Il y a eu un problème lors de la connexion à votre compte.</br><br>
                <br><b> Il se pourrait que vous n'avez pas de compte, si vous le souhaitez vous pouvez en créer un en cliquant sur le lien suivant: </b> 
                <br><a href='?action=InscriptionAction'>Inscription</a></br>
                END;
            }
        }
    }

    public static function checkPasswordStrength(string $pass, int $minimumLength): bool {

        if (strlen($pass) < $minimumLength) return false;
        $digit = preg_match("#[\d]#", $pass); // au moins un digit
        $special = preg_match("#[\W]#", $pass); // au moins un car. spécial
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule

        //On débug en echo pour voir les erreurs
        if (!$digit || !$special || !$lower || !$upper)return false;
        return true;
    }

}