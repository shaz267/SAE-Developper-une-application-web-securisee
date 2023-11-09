<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class TagAction extends Action
{

    public function execute(): string
    {
        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();

        //On récupère les touites
        $sql = "SELECT t.id_touite, t.id_user,u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                WHERE 
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        return Action::renderTouites($touites);
    }
}