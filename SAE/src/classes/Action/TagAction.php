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
                INNER JOIN touitetag tt ON t.id_touite = tt.id_touite
                INNER JOIN tag ON tt.id_tag = tag.id_tag
                WHERE tag.libelle_tag = '{$_GET["hashtag"]}'
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        var_dump($stmt);
        $stmt->execute();
        $touites = $stmt->fetchAll();
        return Action::renderTouites($touites, "");
    }
}