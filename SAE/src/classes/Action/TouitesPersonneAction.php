<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class TouitesPersonneAction extends Action
{

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites et le bandeau de navigation
     * @return string
     */
    public function execute(): string
    {

        //: Afficher une liste de touites en ordre chronologique inverse
        //(les plus récents au début

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

        $htmlSupp = '';

        //Si l'utilisateur est connecté
        if (isset($_SESSION['user'])) {

            //On parcourt les touites
            foreach ($touites as $touite) {
                //On récupère l'utilisateur connecté
                $user = unserialize($_SESSION['user']);
                //Si l'utilisateur connecté est l'auteur de la touite
                if ($user->getIdUser() == $touite['id_user']) {
                    $htmlSupp = <<<HTML
                        <img id="poubelle" src="img/poubelle.png" alt="Boutton de suppression" >
                    HTML;
                } else {
                    $htmlSupp = '';
                }
            }
        }

        return Action::renderTouites($touites, $htmlSupp);

    }
}