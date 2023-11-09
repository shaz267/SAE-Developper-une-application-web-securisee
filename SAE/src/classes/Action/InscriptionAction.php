<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;
use touiteur\classes\Exceptions\NoMailException;

class InscriptionAction extends Action {


    public function execute(): string
    {

        //: Afficher la page d'inscription

        $html = <<<HTML
                 <h2>Bienvenue sur Touiteur, vous pouvez vous inscrire ci-dessous :</h2>
                 <form class="formulaireInsc" method="POST" action="?action=InscriptionAction">
                 <label>Nom : </label>
                 <input type="text" name="nom" placeholder="ex : Votre Nom">
                 <br><br>
                 <label>Prénom : </label>
                 <input type="text" name="prenom" placeholder="ex : Votre Prénom">
                 <br><br>
                 <label>E-mail : </label>
                 <input type="email" name="email" placeholder="ex : dupont.gerard@gmail.com">
                 <br><br>
                 <label>Mot de passe : </label>
                 <input type="password" name="mdp">
                 <br><br>
                 <input type="submit" name="valider" class="button" value="Valider"/>
                 <br><br>
                 </form>
                 <ul id="choix">
                    <li><a href="?action=AuthentificationAction">Connectez vous ici</a></li>
                 </ul>
                 HTML;
        $bonmail = true;

        if(isset($_POST['email'])){
            $mmail = htmlspecialchars($_POST['email']);
            $db = ConnectionFactory::makeConnection();
            $query = 'SELECT email FROM Utilisateur WHERE email = ?';
            $st = $db->prepare($query);
            $st->bindParam(1, $mmail, PDO::PARAM_STR);
            $st->execute();
            $result = $st->fetch(PDO::FETCH_ASSOC);
            if($result){
                $html .= '<p>Cet email est déjà utilisé</p>';
                $bonmail = false;
            }

        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && self::checkPasswordStrength($_POST['mdp'], 8) && $bonmail){
            $this->register();
            $html .= '<p>Vous êtes inscrit avec succès</p>';
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !self::checkPasswordStrength($_POST['mdp'], 8)){
            $html .= '<p>Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial</p>';
        }
        elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
            //afficher le mur
        }
        return $html;
    }

    public static function register(){

        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $mail = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);

        $db = ConnectionFactory::makeConnection();

        $hash=password_hash($mdp, PASSWORD_DEFAULT, ['cost'=> 12] );

        $query = 'INSERT INTO Utilisateur (nom, prenom, email, mdp) VALUES (?, ?, ?, ?)';
        $st = $db->prepare($query);
        $st->bindParam(1, $nom, PDO::PARAM_STR);
        $st->bindParam(2, $prenom, PDO::PARAM_STR);
        $st->bindParam(3, $mail, PDO::PARAM_STR);
        $st->bindParam(4, $hash, PDO::PARAM_STR);
        $st->execute();
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