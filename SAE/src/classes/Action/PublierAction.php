<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class PublierAction extends Action
{

    public function execute(): string
    {
        //un utilisateur rédige un touite et le publie sur la plateforme.

        if ($_SERVER['REQUEST_METHOD'] === 'GET'){

            return <<<END
            <h1>Publier un touite</h1>
            <form class="formulaireAuth" method='post' action='?action=PublierAction'>
            <label>Contenu : </label>
            <textarea type='text' cols="47" rows="5" name='touite' placeholder="Quoi de neuf ?!" maxlength="235"></textarea>
            <br><br>
            <button type='submit'>Publier</button>
            <br><br>
            </form>
            END;
        }
        else{
            $pdo = ConnectionFactory::makeConnection();

            //Partie filtrage du contenu du touite et extraction des hashtags

            //On filtre le contenu du touite
            $_POST['touite'] = filter_var($_POST['touite'], FILTER_SANITIZE_STRING);

            //On extrait les hashtags
            $hashtags = [];
            preg_match_all('/#[^ #]+/i', $_POST['touite'], $hashtags);

            $contenu = $_POST['touite'];

            //On transforme les hashtags en liens
            foreach ($hashtags[0] as $key => $value) {
                $contenu = str_replace($value, "<a href='?action=TagAction&hashtag=".substr($value, 1)."'>$value</a>", $contenu);
            }

            //----------------Partie insertion du touite dans la base de données-------------------
            $user = unserialize($_SESSION['user']);
            $id_user = $user->getIdUser();

            $sql1 = "SELECT MAX(id_touite)+1 AS max FROM TOUITE";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute();
            $maxId = $stmt1->fetch(\PDO::FETCH_ASSOC);

            $sql2 = "INSERT INTO TOUITE VALUES (:id_touite,:id_user, :contenu, NOW())";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':id_touite',$maxId['max']);
            $stmt2->bindParam(':id_user', $id_user);
            $stmt2->bindParam(':contenu', $contenu);
            $stmt2->execute();
            $stmt2->closeCursor();



            //----------------Partie insertion des hashtags dans la base de données-------------------

            for($i = 0; $i < count($hashtags[0]); $i++){
                $sql2 = "SELECT COALESCE(MAX(id_tag), 0) + 1 FROM TAG";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute();
                $maxTag = $stmt2->fetchColumn();
                $stmt2->closeCursor();

                $sql3 = "SELECT COUNT(*) FROM TAG WHERE libelle_tag = :tag";
                $stmt3 = $pdo->prepare($sql3);
                $stmt3->bindParam(':tag', $hashtags[0][$i]);
                $stmt3->execute();
                $nbligne = $stmt3->fetchColumn();
                $stmt3->closeCursor();

                if($nbligne === 0){
                    $sqlTag = "INSERT INTO TAG VALUES (?,?,'')";
                    $stmtTag = $pdo->prepare($sqlTag);
                    $stmtTag->bindParam(1, $maxTag);
                    $stmtTag->bindParam(2, $hashtags[0][$i]);
                    $stmtTag->execute();
                    $stmtTag->closeCursor();

                    $sqlId = "SELECT id_tag FROM TAG WHERE libelle_tag = ?";
                    $stmtId = $pdo->prepare($sqlId);
                    $stmtId->bindParam(1, $hashtags[0][$i]);
                    $stmtId->execute();
                    $tag = $stmtId->fetchColumn();
                    $stmtId->closeCursor();

                    $sqlTouiteTag = "INSERT INTO TOUITETAG VALUES (:touite,:idtag)";
                    $stmtTouiteTag = $pdo->prepare($sqlTouiteTag);
                    $stmtTouiteTag->bindParam(':touite',$maxId['max']);
                    $stmtTouiteTag->bindParam(':idtag',$tag);
                    $stmtTouiteTag->execute();
                    $stmtTouiteTag->closeCursor();
                } else {
                    $sqlId2 = "SELECT id_tag FROM TAG WHERE libelle_tag = ?";
                    $stmtId2 = $pdo->prepare($sqlId2);
                    $stmtId2->bindParam(1, $hashtags[0][$i]);
                    $stmtId2->execute();
                    $tag2 = $stmtId2->fetchColumn();
                    $stmtId2->closeCursor();

                    $sqlTouiteTag2 = "INSERT INTO TOUITETAG VALUES (:touite,:idtag)";
                    $stmtTouiteTag2 = $pdo->prepare($sqlTouiteTag2);
                    $stmtTouiteTag2->bindParam(':touite',$maxId['max']);
                    $stmtTouiteTag2->bindParam(':idtag',$tag2);
                    $stmtTouiteTag2->execute();
                    $stmtTouiteTag2->closeCursor();
                }

            }

            //On redirige vers l'accueil
            header("Location: ?action=MurAction");

            //On ne retourne rien
            return '';

        }
    }
}