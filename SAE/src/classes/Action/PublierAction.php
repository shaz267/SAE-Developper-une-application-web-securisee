<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class PublierAction extends Action
{

    public function execute(): string
    {
        //un utilisateur rédige un touite et le publie sur la plateforme.

        //Si l'utilisateur n'a pas rentré le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){

            return <<<END
            <h1>Publier un touite</h1>
            <form class="formulaireAuth" method='post' action='?action=PublierAction' enctype="multipart/form-data">
            <label>Contenu : </label>
            <textarea type='text' cols="47" rows="5" name='touite' placeholder="Quoi de neuf ?!" maxlength="235"></textarea>
            <br><br>
            <label>Image : </label>
            <input class="formulaireImg" type='file' name='image' accept="image/png, image/jpeg, image/gif, image/jpg">
            <br><br>
            <button type='submit'>Publier</button>
            <br><br>
            </form>
            END;
        }
        else{
            //On se connecte à la base de données
            $pdo = ConnectionFactory::makeConnection();

            //Partie filtrage du contenu du touite et extraction des hashtags
            $contenu = htmlspecialchars($_POST['touite']);

            //On filtre le contenu du touite
            $contenu = filter_var($contenu, FILTER_SANITIZE_STRING);



            //On extrait les hashtags
            $hashtags = [];
            preg_match_all('/#[^ #]+/i', $_POST['touite'], $hashtags);



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


        }

        //Partie upload de l'image
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_FILES['image']['name'] != '') {
            $uploadDir = 'img/';

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
                    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                        $uploadedFileName = $_FILES['image']['name'];
                        $destination = $uploadDir . $uploadedFileName;

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {

                            //On insère dans image le chemin de l'image
                            $sql = "INSERT INTO image (description_image, chemin_fichier) VALUES ('', :chemin_image)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':chemin_image', $destination);
                            $stmt->execute();

                            //On récupère l' id_touite  pour l'insérer dans touiteimage
                            $sql = "SELECT Max(id_touite) FROM touite";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $id_touite = $stmt->fetchColumn();

                            //On récupère l'id de l'image
                            $sql = "SELECT Max(id_image) FROM image";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $id_image = $stmt->fetchColumn();

                            //On insere dans touiteimage l'id du touite et de l'image
                            $sql = "INSERT INTO touiteimage (id_touite, id_image) VALUES ({$id_touite}, {$id_image})";
                            $inser = $pdo->exec($sql);


                        } else {
                            echo "Erreur lors de l'enregistrement du fichier.";
                        }
                    } else {
                        echo "Le fichier n'est pas une image autorisée.";
                    }
                } else {
                    echo "Erreur lors du téléchargement du fichier.";
                }
            }
            //On redirige vers l'accueil
            header("Location: ?action=MurAction");

            //On ne retourne rien
            return '';

    }
}