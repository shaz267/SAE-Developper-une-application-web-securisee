<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;
/**
 * Class TouitesPersonneAction
 * @package touiteur\classes\Action
 */
class TouitesPersonneAction extends Action
{

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites et le bandeau de navigation
     * @return string
     */
    public function execute(): string
    {
        //On se connecte à la base de données
        $pdo = ConnectionFactory::makeConnection();

        //On récupère les touites
        $sql = "SELECT  t.id_touite, t.id_user,u.nom, u.prenom, t.contenu, t.date_pub FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                WHERE t.id_user = {$_GET["id"]}
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();

        // On initialise la variable htmlSupp
        $htmlSupp = '';

        // On vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user'])) {

            // On parcourt les touites
            foreach ($touites as $touite) {

                // On récupère l'id de l'utilisateur
                $user = unserialize($_SESSION['user']);
                //Si l'utilisateur connecté est l'auteur de la touite
                if ($user->getIdUser() == $touite['id_user']) {
                    // On affiche le bouton de suppression
                    $htmlSupp = <<<HTML
                        <img id="poubelle" src="img/poubelle.png" alt="Boutton de suppression" >
                    HTML;
                } else {
                    // On n'affiche pas le bouton de suppression si l'utilisateur n'est pas l'auteur du touite ou si l'utilisateur n'est pas connecté
                    $htmlSupp = '';
                }
            }
        }

        // On retourne le code HTML
        return Action::renderTouites($touites, $htmlSupp);

    }
}