<?php

namespace Action;

class TouitesAction extends Action
{

    public function execute(): string
    {

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
                         
                     </div>
                 </div>
                 HTML;

    }
}