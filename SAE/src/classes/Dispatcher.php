<?php
declare(strict_types=1);

namespace touiteur\classes;

use touiteur\classes\Action\AuthentificationAction;
use touiteur\classes\Action\InscriptionAction;
use touiteur\classes\Action\MurAction;
use touiteur\classes\Action\PublierAction;
use touiteur\classes\Action\TagAction;
use touiteur\classes\Action\TouiteDetailAction;
use touiteur\classes\Action\TouitesAction;
use touiteur\classes\Action\TouitesPersonneAction;
use touiteur\classes\Action\EffacerTouiteAction;

class Dispatcher
{

    private $accueil = "Accueil";

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
                    $this->accueil = "TOUITE DETAIL";
                    break;
                case 'TouitesPersonneAction' :
                    $tPA = new TouitesPersonneAction();
                    $html = $tPA->execute();
                    $this->accueil = "TOUITES D'UNE PERSONNE";
                    break;
                case 'logout' :
                    session_destroy();
                    header('Location: index.php');
                    break;
                case 'PublierAction' :
                    $pA = new PublierAction();
                    $html = $pA->execute();
                    $this->accueil = "PUBLIER UN TOUITE";
                    break;
                case 'TouitesAction' :
                    $tA = new TouitesAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUS LES TOUITES";
                    break;
                case 'TagAction' :
                    $tA = new TagAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUITES DU TAG";
                    break;
                case 'EffacerTouiteAction' :
                    $eTA = new EffacerTouiteAction();
                    $html = $eTA->execute();
                    $this->accueil = "TOUS LES TOUITES";
                    break;
                default:
                    $mA = new MurAction();
                    $html = $mA->execute();
                    $this->accueil = "VOTRE MUR";
                    break;

            }

            $html = <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=MurAction">Votre Mur</a></li>
                         <li id="TousTouite"><a href="?action=TouitesAction">Tous Les Touites</a></li>
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
        else {

            switch ($this->action) {
                case 'TouiteDetailAction':
                    $tDA = new TouiteDetailAction();
                    $html = $tDA->execute();
                    $this->accueil = "TOUITE DETAIL";
                    break;
                case 'TouitesPersonneAction' :
                    $tPA = new TouitesPersonneAction();
                    $html = $tPA->execute();
                    $this->accueil = "TOUITES D'UNE PERSONNE";
                    break;
                case 'InscriptionAction' :
                    $iA = new InscriptionAction();
                    $html = $iA->execute();
                    $this->accueil = "INSCRIPTION";
                    break;
                case 'AuthentificationAction' :
                    $aA = new AuthentificationAction();
                    $html = $aA->execute();
                    $this->accueil = "CONNEXION";
                    break;
                default:

                    $tA = new TouitesAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUS LES TOUITES";
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
            <!DOCTYPE html>
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
                        <div class='accueil'><h1>{$this->accueil}</h1>
                        </div>
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