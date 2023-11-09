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



            //----------------Partie insertion des hashtags dans la base de données-------------------

            //On filtre le contenu du touite
            $_POST['touite'] = filter_var($_POST['touite'], FILTER_SANITIZE_STRING);

            //On extrait les hashtags
            $hashtags = [];
            preg_match_all('/#[^ #]+/i', $_POST['touite'], $hashtags);

            //Pour chaque hashtag
            foreach ($hashtags[0] as $key => $value) {

                //On enlève le #
                $value = substr($value, 1);

                //On envoie les hashtags dans la base de données
                $sql = "INSERT INTO tag (libelle_tag, description_tag) VALUES (:hashtag, '')";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hashtag', $value);
                $stmt->execute();

                //On insere dans touitetag l'id du touite et du tag
                $sql = "INSERT INTO touitetag (id_touite, id_tag) VALUES ((SELECT MAX(id_touite) FROM touite) + 1, (SELECT id_tag FROM tag WHERE libelle_tag = :hashtag))";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hashtag', $value);
                $stmt->execute();
            }

            //On transforme les hashtags en liens
            foreach ($hashtags[0] as $key => $value) {
                $_POST['touite'] = str_replace($value, "<a href='?action=TagAction&hashtag=".substr($value, 1)."'>$value</a>", $_POST['touite']);
            }


            //----------------Partie insertion du touite dans la base de données-------------------
            $user = unserialize($_SESSION['user']);
            $id_user = $user->getIdUser();


            $sql = "INSERT INTO touite (id_user, contenu, date_pub) VALUES (:id_user, :contenu, NOW())";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':contenu', $_POST['touite']);
            $stmt->execute();


            //On redirige vers l'accueil
            header("Location: ?action=MurAction");

            //On ne retourne rien
            return '';

        }
    }
}