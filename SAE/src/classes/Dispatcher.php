<?php
declare(strict_types=1);

namespace touiteur\classes;

use touiteur\classes\Action\AuthentificationAction;
use touiteur\classes\Action\InscriptionAction;
use touiteur\classes\Action\MurAction;
use touiteur\classes\Action\PublierAction;
use touiteur\classes\Action\TouiteDetailAction;
use touiteur\classes\Action\TouitesAction;
use touiteur\classes\Action\TouitesPersonneAction;

class Dispatcher
{

    private $action;

    public function __construct()
    {
        if (isset($_GET["action"]))
            $this->action = $_GET["action"];
        else
            $this->action = "";

        //On filtre l'action pour éviter les injections
        $this->action = filter_var($this->action);
    }

    public function run()
    {
        //Si l'utilisateur est connecté
        if (isset($_SESSION['user'])){

            switch ($this->action) {
                case 'TouiteDetailAction':
                    $tDA = new TouiteDetailAction();
                    $html = $tDA->execute();
                    break;
                case 'TouitesPersonneAction' :
                    $tPA = new TouitesPersonneAction();
                    $html = $tPA->execute();
                    break;
                case 'logout' :
                    session_destroy();
                    header('Location: index.php');
                    break;
                case 'PublierAction' :
                    $pA = new PublierAction();
                    $html = $pA->execute();
                    break;
                default:
                    $mA = new MurAction();
                    $html = $mA->execute();
                    break;

            }

            $html = <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li id="publier"><a href="?action=PublierAction">Publier</a></li>
                         <li id="deconnexion"><a href="?action=logout">Déconnexion</a></li>
                     </ul>
                 </div>
                 <div class="deffilementTouite">
                 
                 
                        $html
                     
                 </div>
                 </div>
                 HTML;
        }
        else{

            switch ($this->action) {
                case 'TouiteDetailAction':
                    $tDA = new TouiteDetailAction();
                    $html = $tDA->execute();
                    break;
                case 'TouitesPersonneAction' :
                    $tPA = new TouitesPersonneAction();
                    $html = $tPA->execute();
                    break;
                case 'InscriptionAction' :
                    $iA = new InscriptionAction();
                    $html = $iA->execute();
                    break;
                case 'AuthentificationAction' :
                    $aA = new AuthentificationAction();
                    $html = $aA->execute();
                    break;
                default:

                    $tA = new TouitesAction();
                    $html = $tA->execute();
                    break;
            }

            $html = <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li id="connexion"><a href="?action=AuthentificationAction">Connexion</a></li>
                         <li id="inscription"><a href="?action=InscriptionAction">Inscription</a></li>
                     </ul>
                 </div>
                 <div class="deffilementTouite">
                 
                 
                        $html
                     
                 </div>
                 </div>
                 HTML;

        }
        $this->renderPage($html);
    }

    private function renderPage(string $html)
    {
        echo <<<HTML
            <html lang="fr">
                <head>
                    <title>Page d'accueil</title>
                    <meta charset=utf-8>
                    <link rel="shortcut icon" href="img/twitter-logo.png"/>
                </head>
                <body>
                <header>
                    <link rel='stylesheet' href='src/css/Index.css'>
                    <div class='container'>
                        <div class='logo'>
                            <a href="index.php">
                                <img class="imageIndex" src="img/logo.png" alt="Le logo principal"/>
                            </a>
                        </div>
                        <div class='accueil'><h1>ACCUEIL</h1></div>
                        <div class="loupe">
                            <img class="imageIndex" src="img/loupe.png" alt="Recherche"/>
                        </div>
                        <div class="recherche">
                            <label>
                                <input type="search" placeholder="Chercher"/>
                            </label>
                        </div>
                    </div>
                </header>
                
                <section>
                    
                        $html
                </section>
                
                
                </body>
                </html>
                
            HTML;

    }

}