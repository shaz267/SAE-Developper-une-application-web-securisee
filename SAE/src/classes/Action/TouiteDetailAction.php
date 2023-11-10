<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;
use touiteur\classes\User;

class TouiteDetailAction extends Action
{

    public function execute(): string
    {
        $touiteId = $_GET['touite_id'];

        $pdo = ConnectionFactory::makeConnection();

        $sql = "SELECT t.id_user, u.nom, u.prenom, t.contenu, t.date_pub, t.id_touite FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                where t.id_touite = $touiteId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touite = $stmt->fetch();

        if(isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            if ($user->getIdUser() == $touite['id_user']) {
                $htmlSupp = <<<HTML
                    <img id="poubelle" src="img/poubelle.png" alt="Boutton de suppression" >
                HTML;
            }else
                $htmlSupp = "";
        }else
            $htmlSupp = "";

        $html =  $this->renderDetailTouites($touite, $htmlSupp);

        if(isset($_POST['boutonsuivre'])){

            // Vérifier que l'utilisateur connecté ne suit pas déjà l'utilisateur du touite
            $query = 'SELECT * FROM SUIT WHERE id_suiveur = ? AND id_suivi = ?';
            $usersuiveur = unserialize($_SESSION['user'])->getIdUser();
            $usersuivi = $touite['id_user'];
            $st = $pdo->prepare($query);
            $st->bindParam(1, $usersuiveur, PDO::PARAM_INT);
            $st->bindParam(2, $usersuivi, PDO::PARAM_INT);
            $st->execute();
            $result = $st->fetchAll();

            if($st->rowCount() != 0){
                $html .= "<script>alert('Vous suivez déjà cet utilisateur.');</script>";
            }
            else{
                // Gérer le fait qu'on ne puisse pas se suivre soi-même
                if($usersuiveur == $usersuivi){
                    $html .= "<script>alert('Vous ne pouvez pas vous suivre vous-même.');</script>";
                }
                else {
                    $query = 'INSERT INTO SUIT (id_suiveur, id_suivi) VALUES (?, ?)';
                    $usersuiveur = unserialize($_SESSION['user'])->getIdUser();
                    $usersuivi = $touite['id_user'];
                    $st = $pdo->prepare($query);
                    $st->bindParam(1, $usersuiveur, PDO::PARAM_INT);
                    $st->bindParam(2, $usersuivi, PDO::PARAM_INT);
                    $st->execute();
                    $html .= "<script>alert('Vous suivez cet utilisateur.');</script>";
                }
            }
        }

        if(isset($_POST['boutonnpsuivre'])){

            $query = 'DELETE FROM SUIT WHERE id_suiveur = ? AND id_suivi = ?';
            $usersuiveur = unserialize($_SESSION['user'])->getIdUser();
            $usersuivi = $touite['id_user'];
            $st = $pdo->prepare($query);
            $st->bindParam(1, $usersuiveur, PDO::PARAM_INT);
            $st->bindParam(2, $usersuivi, PDO::PARAM_INT);
            $st->execute();
            $html.= "<script>alert('Vous ne suivez plus cet utilisateur.');</script>";
        }

        if(isset($_GET['note'])){
            $note = $_GET['note'];
            $query = 'INSERT INTO NOTATION (id_user, id_touite, note) VALUES (?, ?, ?)';
            $user = unserialize($_SESSION['user'])->getIdUser();
            $st = $pdo->prepare($query);
            $st->bindParam(1, $usersuiveur, PDO::PARAM_INT);
            $st->bindParam(2, $touiteId, PDO::PARAM_INT);
            $st->bindParam(3, $note, PDO::PARAM_INT);
            $st->execute();
            $html.= "<script>alert('Vous avez noté ce touite.');</script>";
        }


        return $html;
    }

    private function renderDetailTouites($touite, $htmlSupp): string
    {

        if ($this->cheminImage($touite) != null) {
            $cheminImage = $this->cheminImage($touite);


            $image = <<<HTML
                <img src="{$cheminImage}" alt="Image du touite" width="200" height="200">
            HTML;
        } else {
            $image = '';
        }

        return <<<HTML
                    <div class="touite" id="Detail">
                        <a class="lienPersonne" href="?action=TouitesPersonneAction&id={$touite['id_user']}"><h3>{$touite['nom']} {$touite['prenom']}</h3></a>
                        <form method="post">
                        <input type="submit" name="boutonsuivre" value="Suivre" />
                        <input type="submit" name="boutonnpsuivre" value="Ne plus Suivre" />
                        </form>
                        <p>{$touite['contenu']}</p>
                        <br>
                        <p>{$image}</p>
                        <br>
                        <p>Date du post : {$touite['date_pub']}</p>
                        <br>
                        <a href="?action=TouiteDetailAction&touite_id={$touite['id_touite']}&note=1"> <img id="like" src="img/like.png" alt="Boutton de like"></a>
                        <a href="?action=TouiteDetailAction&touite_id={$touite['id_touite']}$note=-1"><img id="dislike" src="img/dislike.png" alt="Boutton de dislike"></a>
                        <div class="supprimer" onclick="event.stopPropagation(); if (confirm('Voulez-vous vraiment supprimer ce tweet ?')) { location.href='?action=EffacerTouiteAction&touite_id={$touite['id_touite']}' }">
                            $htmlSupp
                        </div>
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

    private function cheminImage($touite): string{
        $pdo = ConnectionFactory::makeConnection();
        $sql = "SELECT image.chemin_fichier FROM image 
            INNER JOIN touiteimage On touiteimage.id_image = image.id_image
            WHERE id_touite = {$touite['id_touite']}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $cheminImage = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($cheminImage['chemin_fichier'])) {
            // La requête a retourné des résultats, on peut les utiliser
            return $cheminImage['chemin_fichier'];
        } else {
            return '';
        }
    }
}