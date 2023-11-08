<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class TouiteDetailAction extends Action
{

    public function execute(): string
    {
        $touiteId = $_GET['touite_id'];

        $pdo = ConnectionFactory::makeConnection();

        $sql = "SELECT t.id_user, u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                where t.id_touite = $touiteId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetch();
        return $this->renderDetailTouites($touites);


    }

    private function renderDetailTouites($touite): string
    {

        //On convertit le contenu en UTF-8
        $touite['contenu'] = utf8_encode($touite['contenu']);

        return <<<HTML
                    <div class="touite" id="Detail">
                        <a class="lienPersonne" href="?action=TouitesPersonneAction&id={$touite['id_user']}"><h3>{$touite['nom']} {$touite['prenom']}</h3></a>
                        <br>
                        <p>{$touite['contenu']}</p>
                        <br>
                        <p>Date du post : {$touite['date_pub']}</p>
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
                    </div>
            HTML;
    }



}