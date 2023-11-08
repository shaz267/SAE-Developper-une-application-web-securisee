<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;

class InscriptionAction extends Action {


    public function execute(): string
    {

        //: Afficher la page d'inscription

        /*$pdo = ConnectionFactory::makeConnection();

        $sql = "SELECT u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        $html = $this->renderTouites($touites);*/

        $html = <<<HTML
                 <form id="inscription" method="POST" action="?action=InscriptionAction">
                 <label>Votre Nom : </label><input type="text" name="nom"><br>
                 <label>Votre Prénom : </label><input type="text" name="prenom"><br>
                 <label>Votre e-mail : </label><input type="text" name="email"><br>
                 <label>Votre mot de passe : </label><input type="password" name="mdp"><br>
                 <input type="submit" name="valider" class="button" value="Valider"/>
                 </form>
                 HTML;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->register();
        }
        elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
            //afficher le mur
        }
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
}