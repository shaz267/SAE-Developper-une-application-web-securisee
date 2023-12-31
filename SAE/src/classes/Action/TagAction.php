<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;

/**
 * Class TagAction, permet d'afficher les touites d'un tag
 * @package touiteur\classes\Action
 */
class TagAction extends Action
{

    public function execute(): string
    {
        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();
        //On récupère les touites
        $sql = "SELECT t.id_touite, t.id_user,u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                INNER JOIN touitetag tt ON t.id_touite = tt.id_touite
                INNER JOIN tag ON tt.id_tag = tag.id_tag
                WHERE tag.libelle_tag = '{$_GET["hashtag"]}'
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        $html = "";

        // On vérifie que l'utilisateur clique sur le bouton suivre tag
        if(isset($_POST['boutonsuivretag'])){
            // On fais une requête pour récupérer l'id du tag
            $query = 'SELECT id_tag FROM TAG WHERE libelle_tag = ?';
            $libelletag = $_GET['hashtag'];
            $st = $pdo->prepare($query);
            $st->bindParam(1, $libelletag, PDO::PARAM_STR);
            $st->execute();
            $result = $st->fetch();
            $idtag = $result['id_tag'];

            // On fais une requête pour insérer le tag dans la table suittag
            try{
                $query2 = 'INSERT INTO SUITTAG (id_user, id_tag) VALUES (?, ?)';
                $usersuiveur = unserialize($_SESSION['user'])->getIdUser();
                $st2 = $pdo->prepare($query2);
                $st2->bindParam(1, $usersuiveur, PDO::PARAM_INT);
                $st2->bindParam(2, $idtag, PDO::PARAM_INT);
                $st2->execute();
                $html .= "<script>alert('Vous suivez désormais ce tag.');</script>";
            } catch (\PDOException $e){}
        }

        //On rend le code HTML avec la fonction renderTouites
        return Action::renderTouites($touites, "") . $html;
    }

    /**
     * @return string, le code HTML du bouton suivre tag
     */
    public static function insererBoutonSuivreTag():string {

        return <<<HTML
                    <form method="post" action="">
                        <input type="submit" name="boutonsuivretag" value="Suivre le Tag">
                    </form>
                HTML;
    }
}