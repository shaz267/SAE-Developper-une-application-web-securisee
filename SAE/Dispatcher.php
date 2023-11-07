<?php

class Dispatcher
{

    private $action;

    public function __construct()
    {
        $this->action = $_GET['action'];
    }

    public function run(){

        switch ($this->action){
            case 'TouitesAction':
                $tA = new TouitesAction();
                $html = $tA->execute();


                break;
            default:
                $this->executeAction(new DefaultAction());

        }
    }

    private function renderPage(string $html){
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
                            <a href="index.php">
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