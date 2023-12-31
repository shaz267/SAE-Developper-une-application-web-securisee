<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;

class EffacerTouiteAction extends Action
{

    public function execute(): string
    {

        // On récupère l'id du touite à effacer
        $touiteId = $_GET['touite_id'];



        if (empty($touiteId)) {
            // Le touite_id est vide, on affiche un message d'erreur
            echo "L'identifiant du touite est vide.";
            return '';
        }else{
            // On se connecte à la base de données
            $pdo = ConnectionFactory::makeConnection();

            $sql = "SELECT id_tag FROM TOUITETAG WHERE id_touite = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $touiteId, PDO::PARAM_INT);
            $stmt->execute();
            $touite = $stmt->fetchAll();
            if($stmt->rowCount() != 0){
                foreach($touite as $tag){
                    $sql = "DELETE FROM TOUITETAG WHERE id_tag = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1,$tag['id_tag'],PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();
                }
            } else {
                $sql = "SELECT id_image from touiteimage where id_touite = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $touiteId, PDO::PARAM_INT);
                $stmt->execute();
                $touite = $stmt->fetchAll();
                if ($stmt->rowCount() != 0) {
                    foreach ($touite as $image) {
                        $sql = "DELETE FROM touiteimage WHERE id_image = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(1, $image['id_image'], PDO::PARAM_INT);
                        $stmt->execute();
                        $stmt->closeCursor();
                    }
                } else {
                    // On exécute la requête SQL
                    $sql = "DELETE FROM touite WHERE id_touite = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $touiteId, PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();
                }
            }


            // On redirige l'utilisateur vers la page d'accueil
            header("Location: ?action=MurAction");
        }

        //On ne retourne rien
        return '';
    }


}