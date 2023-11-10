<?php
declare(strict_types=1);

namespace touiteur\classes;

use touiteur\classes\Action\AuthentificationAction;
use touiteur\classes\Action\InscriptionAction;
use touiteur\classes\Action\MurAction;
use touiteur\classes\Action\NarcissiqueAction;
use touiteur\classes\Action\PublierAction;
use touiteur\classes\Action\TagAction;
use touiteur\classes\Action\TouiteDetailAction;
use touiteur\classes\Action\TouitesAction;
use touiteur\classes\Action\TouitesPersonneAction;
use touiteur\classes\Action\EffacerTouiteAction;

class Dispatcher
{

    /**
     * @var string Le tag du bouton
     */
    public $buttonTag = "";

    /**
     * @var string Le nom de du titre de la page
     */
    private $accueil = "Accueil";


    /**
     * @var string L'action à effectuer
     */
    private $action;

    /**
     * Dispatcher constructor. On récupère l'action à effectuer dans l'URL
     */
    public function __construct()
    {
        //Si l'action est définie dans l'URL
        if (isset($_GET["action"]))
            $this->action = $_GET["action"];
        else //Sinon on met l'action à vide et ce serra donc l'action par défaut qui sera exécutée
            $this->action = "";
    }

    public function run()
    {

        $pagination = "";

        //Si l'utilisateur est connecté
        if (isset($_SESSION['user'])) {

            $user = unserialize($_SESSION['user']);
            $nomPrenom = $user->prenom . " " . $user->nom;

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
                    $this->accueil = "PUBLIER UN TOUITE - $nomPrenom";
                    break;
                case 'TouitesAction' :
                    $tA = new TouitesAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUS LES TOUITES";
                    $pagination = $this->pagination();
                    break;
                case 'TagAction' :
                    $tA = new TagAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUITES DU TAG";
                    $this->buttonTag = TagAction::insererBoutonSuivreTag();
                    break;
                case 'EffacerTouiteAction' :
                    $eTA = new EffacerTouiteAction();
                    $html = $eTA->execute();
                    break;
                case 'NarcissiqueAction' :
                    $nA = new NarcissiqueAction();
                    $html = $nA->execute();
                    $this->accueil = "Infos De Votre Compte - $nomPrenom";
                    break;
                default:
                    $mA = new MurAction();
                    $html = $mA->execute();
                    $this->accueil = "VOTRE MUR - $nomPrenom";
                    break;
            }

            $html = <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=MurAction">Votre Mur</a></li>
                         <li id="TousTouite"><a href="?action=TouitesAction">Tous Les Touites</a></li>
                         <li id="publier"><a href="?action=PublierAction">Publier</a></li>
                         <li id="narcissique"><a href="?action=NarcissiqueAction">Infos Du Compte</a></li>                         
                         <li id="deconnexion"><a href="?action=logout">Déconnexion</a></li>
                        
                         {$pagination}
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
                case 'TagAction' :
                    $tA = new TagAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUITES DU TAG";
                    break;
                default:

                    $tA = new TouitesAction();
                    $html = $tA->execute();
                    $this->accueil = "TOUS LES TOUITES";
                    $pagination = $this->pagination();
                    break;
            }

            $html = <<<HTML
                 <div class="touites" id="index">
                 <div class="liens">
                     <ul id="choix">
                         <li><a href="?action=TouitesAction">Accueil</a></li>
                         <li id="connexion"><a href="?action=AuthentificationAction">Connexion</a></li>
                         <li id="inscription"><a href="?action=InscriptionAction">Inscription</a></li>
                         {$pagination}
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
        if(isset($_POST['recherchertag'])){
            $tag = $_POST['recherchertag'];
            header("Location: ?action=TagAction&hashtag=$tag");
        }
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
                        {$this->buttonTag}
                        </div>
                        <div class="loupe">
                            <button type="submit" class="boutonrecherche"><img class="imageIndex" src="img/loupe.png" alt="Recherche"/></button>
                        </div>
                        <div class="recherche">
                            <label>
                                <form method="post">
                                <input name="recherchertag" placeholder="Rechercher un tag">
                                </form>
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

    public function pagination(): string
    {
        // On récupère le nombre de pages et la page courante
        $pages = TouitesAction::getPages();
        $currentPage = TouitesAction::getCurrentPage();

        $html = <<<HTML
            <li id="pagination"><nav id="pag">
        HTML;

        // Boucle sur les pages
        for ($page = 1; $page <= $pages; $page++) {
            $html .= <<<HTML
        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
        <li class="page-item <?= ($currentPage == $page) ? " active" : "" ?>| 
            <a  href="?action=TouitesAction&page=$page" class="page-link">$page</a>
        </li>
        HTML;
        }

        $html .= '</nav></li>';

        return $html;
    }




}