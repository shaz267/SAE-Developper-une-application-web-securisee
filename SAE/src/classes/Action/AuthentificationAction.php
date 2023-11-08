<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;
use touiteur\classes\Exceptions\Authentication;
use touiteur\classes\Exceptions\AuthException;
use touiteur\classes\User;

class AuthentificationAction extends Action
{


    /**
     * Fonction qui permet d'afficher la page d'authentification
     * @return string
     */
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
                         <li id="connexion"><a href="?action=AuthentificationAction">Connexion</a></li>
                         <li id ="inscription"><a href="?action=InscriptionAction">Inscription</a></liid>
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
        $query = $bdd->prepare('SELECT mdp FROM utilisateur WHERE email = ?');
        $query->bindParam(1,$email);
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

    /**
     * Fonction qui permet de charger le profil de l'utilisateur en session
     * @param string $email
     * @return void
     */
    private static function loadProfile(string $email) : void {

        // On se connecte à la base et on sélectionne le nom, prenom et droits de l'email donné
        $bdd = ConnectionFactory::makeConnection();
        $query = $bdd->prepare("SELECT nom,prenom FROM UTILISATEUR WHERE email = ?");
        $query->bindParam(1, $email);
        $query->execute();
        $info = $query->fetch(PDO::FETCH_ASSOC);

        // On crée le nouvel objet User qui sera utilisé le temps de la session
        $user = new User($info['nom'], $info['prenom'], $email);
        $user = serialize($user);
        $_SESSION['user'] = $user;
    }

    private function renderAuthentification() : string {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<END
                <h1>Bienvenue sur Touiteur</h1>
                <form class="formulaireAuth" method='post' action='?action=AuthentificationAction'>
                <label>Email : </label><input type='text' name='email'>
                <label>Mot de passe : </label><input type='password' name='mdp'>
                <button type='submit'>Se connecter</button><br><br>
                <ul id="choix">
                <li><a href='?action=InscriptionAction'>Inscrivez vous dès maintenant ici</a></li>
                </ul>
                </form>
            END;
        }
        else {

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['mdp'];

            try {
                AuthentificationAction::authenticate($email, $password);
                $user = unserialize($_SESSION['user']);

                //On veut changer la page pour afficher le mur de l'utilisateur
                header("Location: ?action=MurAction");

                return <<<END
                    <h1>Bienvenue {$user->nom} {$user->prenom}</h1>
                    <a href='?action=logout'>Se déconnecter</a>
                END;
            } catch (AuthException $e) {

                $message = $e->getMessage();
                return <<<END
                <br>{$message}<br>
                <br><b> Il se pourrait que vous n'avez pas de compte, si vous le souhaitez vous pouvez en créer un en cliquant sur le lien suivant: </b> 
                <br>
                <ul id="choix">
                <li><a href='?action=InscriptionAction'>Inscrivez vous dès maintenant ici</a></li>
                </ul>
                END;
            }
        }
    }

}