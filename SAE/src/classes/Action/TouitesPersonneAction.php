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
        $sql = "SELECT u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        $html = $this->renderTouites($touites);

        //On retourne le code HTML
        return  <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li><a href="?action=Connexion">Connexion</a></li>
                         <li><a href="?action=Inscription">Inscription</a></li>
                     </ul>
                 </div>
                 <div class="deffilementTouite">
                     
                        $html
                     
                 </div>
                 </div>
                 HTML;

    }

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites
     * @param array $touites
     * @return string
     */
    private function renderTouites(array $touites): string
    {

        $html = "";
        //On parcourt les touites
        foreach ($touites as $touite) {

            //On convertit le contenu en UTF-8
            $touite['contenu'] = utf8_encode($touite['contenu']);

            //On réduit le contenu pour l'afficher en version courte
            $touite['contenu'] = substr($touite['contenu'], 0, 40) . ' ...';


            //On convertit les caractères spéciaux en entités HTML
            $touite['contenu'] = htmlspecialchars($touite['contenu']);
            $touite['date_pub'] = htmlspecialchars($touite['date_pub']);
            $touite['nom'] = htmlspecialchars($touite['nom']);

            $html .= <<<HTML
            <div class="touite">
                <h3>{$touite['nom']} {$touite['prenom']}</h3>
                <br>
                <p>{$touite['contenu']}</p>
                <br> <br> <br> <br> <br> 
                <p>Date du post : {$touite['date_pub']}</p>
            </div>
            HTML;
        }
        //On retourne le code HTML
        return $html;
    }
}