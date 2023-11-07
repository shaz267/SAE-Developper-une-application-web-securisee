<?php

namespace src\Action;

use Action\Action;

class TouiteDetailAction extends Action
{

    public function execute(): string
    {
        return <<<HTML
        <html lang="fr">
        <head>
            <title>Page d'accueil</title>
            <meta charset="utf-8">
            <link rel="shortcut icon" href="../../img/twitter-logo.png"/>
        </head>
        <body>
        <header>
            <link rel='stylesheet' href='../TouiteDetail.css'>
            <div class='container'>
                <div class='logo'>
                    <a href="../index.php">
                        <img src="../../img/logo.png" alt="Le logo principal"/>
                    </a>
                </div>
                <div class='accueil'></div>
                <div class="loupe">
                    <img src="../../img/loupe.png" alt="Recherche"/>
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
                        <li><a href="../index.php">Accueil</a></li>
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
                        <br>
                        <img id="like" src="../../img/like.png" alt="Boutton de like">
                        <img id="dislike" src="../../img/dislike.png" alt="Boutton de dislike">
                    </div>
                    <div class="Commentaire">
                        <h2>Commentaires</h2>
                        <h3>user1</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user2</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user4</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user5</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user6</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
        
        
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