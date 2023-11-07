<?php
declare(strict_types=1);

namespace src\classes;

use Action\TouitesAction;
use \src\classes\ConnectionFactory;

require_once 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

class Dispatcher
{

    private $action;
    private $html;

    public function __construct()
    {
        if (isset($_GET["action"]))
            $this->action = $_GET["action"];
        else
            $this->action = "";
        $this->html = "";
    }

    public function run()
    {

        switch ($this->action) {
            case 'TouitesAction':
                $tA = new TouitesAction();
                $this->html = $tA->execute();
                $this->renderPage($this->html);
                break;
            default:

                $this->renderPage($this->html);

        }
    }

    private function renderPage(string $html)
    {
        echo <<<HTML
            <html lang="fr">

                <head>
                    <title>Page d'accueil</title>
                    <meta charset="utf-8">
                    <link rel="shortcut icon" href="img/twitter-logo.png"/>
                </head>
                <body>
                <header>
                    <link rel='stylesheet' href='css.css'>
                    <div class='container'>
                        <div class='logo'>
                            <a href="?action=TouitesAction">
                                <img src="img/logo.png" alt="Le logo principal"/>
                            </a>
                        </div>
                        <div class='accueil'><h1>ACCUEIL</h1></div>
                        <div class="loupe">
                            <img src="img/loupe.png" alt="Recherche"/>
                        </div>
                        <div class="recherche">
                            <label>
                                <input type="search" placeholder="Chercher"/>
                            </label>
                        </div>
                    </div>
                </header>
                
                <section>
                    <div class="touites">
                
                        $this->html
                    </div>
                    <aside>
                        <div>
                
                        </div>
                    </aside>
                </section>
                
                
                </body>
                </html>
                
            HTML;

    }

}