<?php

namespace touiteur\classes\Action;
use touiteur\classes\ConnectionFactory;

class TouitesAction extends Action
{

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites et le bandeau de navigation
     * @return string
     */
    public function execute(): string
    {

        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();

        //On récupère le nombre total de touites
        $sql = "SELECT COUNT(*) AS total FROM touite";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        $total = $result['total'];

        $currentPage = 1;
        // On détermine sur quelle page on se trouve
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }

        $parPage = 5;

        // On calcule le nombre de pages total
        $pages = ceil($total/ $parPage);


        //On récupère les touites
//        $sql = "SELECT t.id_touite, t.id_user,u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
//                INNER JOIN utilisateur u ON t.id_user = u.id_user
//                ORDER BY t.date_pub DESC LIMIT 0, 5";
//        $stmt = $pdo->prepare($sql);
//        $stmt->execute();

        // Calcul du 1er article de la page
        $premier = ($currentPage * $parPage) - $parPage;

        $sql = "SELECT t.id_touite, t.id_user,u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                ORDER BY t.date_pub DESC LIMIT $premier, $parPage";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touite = $stmt->fetchAll();

        $htmlSupp = '';

        //On appelle la fonction renderTouites pour afficher les touites
        return Action::renderTouites($touite, $htmlSupp);

    }

    /**
     * Fonction qui permet de retourner le nombre de pages total
     * @return float
     */
    static function getPages(){
        $pdo = ConnectionFactory::makeConnection();

        //On récupère le nombre total de touites
        $sql = "SELECT COUNT(*) AS total FROM touite";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        $total = $result['total'];

        $parPage = 5;

        // On calcule le nombre de pages total
        $pages = ceil($total/ $parPage);

        return $pages;
    }

    static function getCurrentPage(){
        $currentPage = 1;
        // On détermine sur quelle page on se trouve
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }

        return $currentPage;
    }
}