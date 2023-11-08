<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class TouitesPersonneAction extends Action
{

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites et le bandeau de navigation
     * @return string
     */
    public function execute(): string
    {

        //: Afficher une liste de touites en ordre chronologique inverse
        //(les plus récents au début

        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();

        //On récupère les touites
        $sql = "SELECT  t.id_touite, t.id_user,u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                WHERE t.id_user = {$_GET["id"]}
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        $html = Action::renderTouites($touites);

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
}