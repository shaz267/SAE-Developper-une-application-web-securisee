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


            $sql = "INSERT INTO touite (id_user, contenu, date_pub) VALUES (:id_user, :contenu, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':contenu', $contenu);
            $stmt->execute();



            //----------------Partie insertion des hashtags dans la base de données-------------------


            //On récupère l' id_touite  pour l'insérer dans touitetag
            $sql = "SELECT MAX(id_touite) FROM touite";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $id_touite = $stmt->fetch();

            //Pour chaque hashtag
            foreach ($hashtags[0] as $value) {

                //On enlève le #
                $value = substr($value, 1);

                //On envoie les hashtags dans la base de données
                $sql = "INSERT INTO tag (libelle_tag, description_tag) VALUES (:hashtag, '')";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hashtag', $value);
                $stmt->execute();

                //On récupere l'id du tag
                $sql = "SELECT id_tag FROM tag WHERE libelle_tag = :hashtag ORDER BY id_tag DESC LIMIT 1";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hashtag', $value);
                $stmt->execute();
                $id_tag = $stmt->fetch();


                //On insere dans touitetag l'id du touite et du tag
                $sql = "INSERT INTO touitetag (id_touite, id_tag) VALUES ({$id_touite[0]}, {$id_tag[0]})";
                $inser = $pdo->exec($sql);


            }
            //On redirige vers l'accueil
            header("Location: ?action=MurAction");

            //On ne retourne rien
            return '';

        }
    }
}