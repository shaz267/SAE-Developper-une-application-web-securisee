<?php

namespace touiteur\classes\Action;

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
                 <form id="inscription" method="POST" action="?action=Inscription">
                 <label>Votre Nom : </label><input type="text" name="nom"><br>
                 <label>Votre Prénom : </label><input type="text" name="prenom"><br>
                 <label>Votre e-mail : </label><input type="text" name="email"><br>
                 <label>Votre mot de passe : </label><input type="text" name="mdp">
                 </form>
                 HTML;

        return  <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li><a href="?action=Connexion">Connexion</a></li>
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