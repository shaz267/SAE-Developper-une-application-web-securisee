<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class MurAction extends Action
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

        //on récupere l'user
        $user = unserialize($_SESSION['user']);

        //afficher les touites
        //qui l’intéressent le plus. Il s’agit des touites des personnes que l’utilisateur suit ainsi que
        //les touites mentionnant un tag auquel il est abonné
        $sql = "SELECT DISTINCT t.id_touite, t.id_user, u.nom, u.prenom, t.contenu, t.date_pub
                FROM touite t
                INNER JOIN utilisateur u ON t.id_user = u.id_user
                LEFT JOIN suit s ON s.id_suivi = t.id_user
                LEFT JOIN suittag st ON st.id_tag IN (
                    SELECT id_tag
                    FROM suittag
                    WHERE id_user = {$user->getIdUser()}
                )
                WHERE s.id_suiveur = {$user->getIdUser()} OR t.id_touite IN (
                    SELECT tt.id_touite
                    FROM touitetag tt
                    WHERE tt.id_tag IN (
                        SELECT id_tag
                        FROM suittag
                        WHERE id_user = {$user->getIdUser()}
                    )
                )
                ORDER BY t.date_pub DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $touites = $stmt->fetchAll();

        $html = "";
        $htmlSup = "";
        //On parcourt les touites
        foreach ($touites as $touite) {

            //On réduit le contenu pour l'afficher en version courte
            $touite['contenu'] = Action::couperTexte($touite['contenu'], 40);

            //On décode le contenu
            $touite['contenu'] = htmlspecialchars_decode($touite['contenu']);

            if(isset($_SESSION['user'])) {
                $user = unserialize($_SESSION['user']);
                if ($user->getIdUser() == $touite['id_user']) {
                    $htmlSupp = <<<HTML
                    <img id="poubelle" src="img/poubelle.png" alt="Boutton de suppression" >
                HTML;
                }else
                    $htmlSupp = "";
            }else
                $htmlSupp = "";


            //On ajoute le code HTML du touite
            $html .= <<<HTML
            <div class="touite" onclick="location.href='?action=TouiteDetailAction&touite_id={$touite['id_touite']}'">
                <a class="lienPersonne" href="?action=TouitesPersonneAction&id={$touite['id_user']}"><h3>{$touite['nom']} {$touite['prenom']}</h3></a>
                <br>
                <p>{$touite['contenu']}</p>
                <br>
                <p>Date du post : {$touite['date_pub']}</p>
                <br>
                <div class="supprimer" onclick="event.stopPropagation(); if (confirm('Voulez-vous vraiment supprimer ce tweet ?')) { location.href='?action=EffacerTouiteAction&touite_id={$touite['id_touite']}' }">
                    $htmlSupp
                </div>
                <br>
            </div>
            HTML;
        }
        //On retourne le code HTML
        return $html;

    }

}