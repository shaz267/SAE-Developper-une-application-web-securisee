<?php

namespace touiteur\classes\Action;
use touiteur\classes\ConnectionFactory;

class TouitesAction extends Action
{

    public function execute(): string
    {

        //: Afficher une liste de touites en ordre chronologique inverse
        //(les plus récents au début

        $pdo = ConnectionFactory::makeConnection();

        $sql = "SELECT u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        $html = $this->renderTouites($touites);

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

    private function renderTouites(array $touites): string
    {

        $html = "";
        foreach ($touites as $touite) {

            //On réduit le contenu pour l'afficher en version courte
            $touite['contenu'] = substr($touite['contenu'], 0, 50) . '...';


            $touite['date_pub'] = htmlspecialchars($touite['date_pub']);
            $touite['nom'] = htmlspecialchars($touite['nom']);

            $html .= <<<HTML
            <div class="touite">
                <h3>{$touite['nom']} {$touite['prenom']}</h3>
                <p>{$touite['contenu']}</p>
                <p>{$touite['date_pub']}</p>
            </div>
            HTML;
        }
        return $html;
    }
}