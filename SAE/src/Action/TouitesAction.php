<?php

namespace Action;

class TouitesAction extends Action
{

    public function execute(): string
    {

        return  <<<HTML
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=index.php">Accueil</a></li>
                         <li><a href="profil.php">Profil</a></li>
                         <li><a href="parametre.php">Parametre</a></li>
                         <li><a href="deconnexion.php">Connexion</a></li>
                     </ul>
                 </div>
                 <div class="deffilementTouite">
                     <div class="touite">
                         
                     </div>
                 </div>
                 HTML;

    }
}