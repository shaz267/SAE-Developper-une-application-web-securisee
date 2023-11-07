<?php

use SAE\src\classes\TouitesAction;

require_once 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

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
                $html = $this->executeAction(new TouitesAction());
                $this->renderPage($html);
                break;
            default:
                $html = $this->executeAction(new DefaultAction());
                $this->renderPage($html);

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
                
                        <div class="liens">
                            <ul id="choix">
                                <li><a href="index.php">Accueil</a></li>
                                <li><a href="profil.php">Profil</a></li>
                                <li><a href="parametre.php">Parametre</a></li>
                                <li><a href="deconnexion.php">Deconnexion</a></li>
                            </ul>
                        </div>
                        <div class="deffilementTouite">
                            <div class="touite">
                                <h1>Profil du touitos</h1>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel dui metus. Sed
                                facilisis nunc a felis placerat, in venenatis quam placerat. Sed fringilla mauris id eros
                                consectetur, a tincidunt nunc venenatis. Nulla leo nunc, vestibulum eu justo non, viverra tincidunt
                                mi.
                                Nullam cursus eget ligula vel finibus.
                                Ut sed facilisis nulla, sed placerat velit. Integer rhoncus felis dolor, quis interdum tellus
                                finibus ut.
                                Aenean convallis feugiat magna, at tincidunt libero varius quis. Nullam semper lorem velit, a
                                finibus metus fringilla ac. Vestibulum semper varius leo, ac elementum elit blandit pulvinar. Donec
                                tempus fermentum elit a posuere. Fusce volutpat ipsum eget nisl suscipit tempus. Phasellus finibus
                                porttitor porta.
                                Nulla eleifend sem a nulla placerat ultricies. Nulla sed nunc commodo, convallis lacus ac, viverra
                                turpis. Vivamus congue nisl eget turpis dignissim bibendum. Vivamus ac volutpat velit.
                                Quisque a justo orci. Aenean varius mattis nisi condimentum ultrices. Vestibulum faucibus quis ex
                                sed aliquam. Vivamus in mauris eu leo vestibulum auctor ullamcorper nec orci. Ut mollis hendrerit
                                cursus.
                                Quisque at ultrices purus, eget blandit felis. Aenean quis fermentum augue. Praesent iaculis dui eu
                                dolor pharetra, scelerisque lobortis lorem accumsan. Nulla laoreet, magna sit amet placerat
                                faucibus, nibh sem ullamcorper nibh, eu eleifend ipsum tortor sed dui.
                                Aliquam erat volutpat. Aenean ut nisl pulvinar, venenatis diam et,
                                volutpat justo. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus
                                mus. Nunc in aliquet ex, ac rhoncus elit. Donec.
                            </div>
                        </div>
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