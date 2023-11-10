<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class NarcissiqueAction extends Action
{

    public function execute(): string
    {

        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();

        //On récupere l'user connecté
        $user = unserialize($_SESSION['user']);

        //On récupère les noms des utilisateurs qui suivent l'utilisateur connecté
        $sql = "SELECT u.id_user, u.nom, u.prenom FROM utilisateur u
                INNER JOIN suit s ON u.id_user = s.id_suiveur
                WHERE s.id_suivi = {$user->getIdUser()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();



        //On récupère le score moyen des touites de l'utilisateur connecté
        $sql = "SELECT AVG(score) as score FROM touite WHERE id_user = {$user->getIdUser()}";

        $html = "";

        foreach($users as $u){
            $html .= <<<HTML
                <li><a href="?action=TouitesPersonneAction&id={$u['id_user']}">{$u['prenom']} {$u['nom']}</a></li>
            HTML;

        }


        //On retourne les nom des utilisateurs qui suivent l'utilisateur connecté
        return <<<HTML
        <h1>Utilisateurs qui suivent {$user->prenom} {$user->nom}</h1>
        <ul>
            {$html}
        HTML;


    }
}