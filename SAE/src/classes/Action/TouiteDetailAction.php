<?php

namespace touiteur\classes\Action;

class TouiteDetailAction extends Action
{

    public function execute(): string
    {
        return <<<HTML
        <div class="touites" id="detail">
                <div class="liens">
                    <ul id="choix">
                        <li><a href="?action=TouiteAction.php">Accueil</a></li>
                    </ul>
                </div>
                <div class="deffilementTouite">
                    <div class="touite">
                        
                        <br>
                        <img id="like" src="img/like.png" alt="Boutton de like">
                        <img id="dislike" src="img/dislike.png" alt="Boutton de dislike">
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
                        <h3>user7</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user8</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user9</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user10</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user11</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user12</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
                        <h3>user13</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin hendrerit nec est id elementum. Nulla
                            varius enim ac enim accumsan gravida. Vestibulum gravida nisl quis ligula bibendum ornare. Fusce
                            scelerisque mi at dolor dapibus aliquet.</p>
        
        
                    </div>
                </div>
            </div>
    HTML;
    }



}