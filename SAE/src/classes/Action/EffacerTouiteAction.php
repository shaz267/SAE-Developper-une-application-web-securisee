<?php

namespace touiteur\classes\Action;

use PDO;
use touiteur\classes\ConnectionFactory;

class EffacerTouiteAction extends Action
{
    public function execute(): string
    {

        $touiteId = $_GET['touite_id'];

        if (empty($touiteId)) {
            // Le touite_id est vide, on affiche un message d'erreur
            echo "L'identifiant du touite est vide.";
            return '';
        }else{
            // On se connecte à la base de données
            $pdo = ConnectionFactory::makeConnection();

            // On exécute la requête SQL
            $sql = "DELETE FROM touite WHERE id_touite = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $touiteId, PDO::PARAM_INT);
            $stmt->execute();

            // On redirige l'utilisateur vers la page d'accueil
            header("Location: ?action=MurAction");
        }

        //On ne retourne rien
        return '';
    }


}