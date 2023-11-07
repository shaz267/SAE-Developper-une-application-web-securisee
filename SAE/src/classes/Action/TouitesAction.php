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

        $sql = "SELECT * FROM touite ORDER BY date DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        $html = $this->renderTouites($touites);

        return  <<<HTML
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li><a href="?action=Connexion">Connexion</a></li>
                         <li><a href="?action=Inscription">Inscription</a></li>
                     </ul>
                 </div>
                 <div class="deffilementTouite">
                     <div class="touite">
                        $html
                     </div>
                 </div>
                 HTML;

    }

    private function renderTouites(array $touites): string
    {
        $html = "";
        foreach ($touites as $touite) {
            $html .= <<<HTML
            <div class="touite">
                <h1>{$touite['id_user']}</h1>
                {$touite['contenu']}
                <p>{$touite['date_pub']}</p>
            </div>
            HTML;
        }
        return $html;
    }
}