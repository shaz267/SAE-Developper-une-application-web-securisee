<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

/**
 * Class NarcissiqueAction
 * @package touiteur\classes\Action
 */
class NarcissiqueAction extends Action
{

    /**
     * Fonction qui permet de retourner le code HTML
     * @return string, le code HTML
     */
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

        $htmlUsers = "";

        //Pour chaque utilisateur
        foreach($users as $u){

            $htmlUsers .= <<<HTML
                <li><a href="?action=TouitesPersonneAction&id={$u['id_user']}">{$u['prenom']} {$u['nom']}</a></li>
            HTML;
        }


        //On récupère le score moyen des touites de l'utilisateur connecté
        $sql = "SELECT ROUND(AVG(note), 2) as scoreMoyen FROM notation WHERE id_user = {$user->getIdUser()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $scoreMoyen = $stmt->fetch();

        //On affecte le score moyen
        if($scoreMoyen['scoreMoyen'] == null){
            $htmlScoreMoyen = "Vous n'avez pas de notes pour vos touites";
        }else{
            $htmlScoreMoyen = "Votre score moyen est de {$scoreMoyen['scoreMoyen']}";
        }


        //On retourne les nom des utilisateurs qui suivent l'utilisateur connecté
        return <<<HTML
        <h2>Utilisateurs qui suivent {$user->prenom} {$user->nom}</h2>
        <ul>
            {$htmlUsers}
        </ul>
        <h2>Score moyen de vos touites</h2>
        <p>{$htmlScoreMoyen}</p>
        HTML;


    }
}