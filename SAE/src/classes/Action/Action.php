<?php

namespace touiteur\classes\Action;
;
abstract class Action
{

    abstract public function execute(): string;

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites
     * @param array $touites
     * @return string
     */
    public static function renderTouites(array $touites, $htmlSupp): string
    {

        $html = "";
        //On parcourt les touites
        foreach ($touites as $touite) {

            //On decode le contenu
            $touite['contenu'] = htmlspecialchars_decode($touite['contenu']);

            //On réduit le contenu pour l'afficher en version courte
            $touite['contenu'] = self::couperTexte($touite['contenu'], 40);

            $html .= <<<HTML
            <div class="touite" onclick="location.href='?action=TouiteDetailAction&touite_id={$touite['id_touite']}'">
                <a class="lienPersonne" href="?action=TouitesPersonneAction&id={$touite['id_user']}"><h3>{$touite['nom']} {$touite['prenom']}</h3></a>
                <br>
                <p>{$touite['contenu']}</p>
                <br>
                <p>Date du post : {$touite['date_pub']}</p>
                <br>
                <div class="supprimer" onclick="event.stopPropagation(); if (confirm('Voulez-vous vraiment supprimer ce tweet ?')) {location.href='?action=EffacerTouiteAction&touite_id={$touite['id_touite']}'}">
                            $htmlSupp
                </div>
                <br>        
            </div>
            HTML;
        }
        //On retourne le code HTML
        return $html;
    }


    /**
     *  Fonction qui permet de couper un texte à une longueur maximale en ignorant la partie balise HTML <a c'est à dire en ne coupant pas au milieu d'un lien
     * @param $texte
     * @param $longueurMax
     * @return mixed|string
     */
    static function couperTexte($texte, $longueurMax) {
        // Vérifie si la longueur du texte est inférieure à la longueur maximale
        if (strlen($texte) <= $longueurMax) {
            return $texte;
        }

        // Découpe le texte à la longueur maximale
        $texteCoupe = substr($texte, 0, $longueurMax);

        // Trouve la dernière balise <a>
        $derniereBaliseA = strrpos($texteCoupe, '<a');

        // Trouve la dernière balise </a>
        $derniereBaliseFermanteA = strrpos($texteCoupe, '</a>');

        // Vérifie si la dernière balise <a> est ouverte mais n'est pas fermée avant la fin
        if ($derniereBaliseA !== false && ($derniereBaliseFermanteA === false || $derniereBaliseFermanteA < $derniereBaliseA)) {
            // Trouve la position de la dernière balise ouvrante <a> après laquelle la balise doit être fermée
            $prochaineBaliseFermanteA = strpos($texte, '</a>', $derniereBaliseA);

            // Si une balise fermante <a> est trouvée après la balise ouvrante <a>, ajuste la coupure
            if ($prochaineBaliseFermanteA !== false) {
                $texteCoupe = substr($texte, 0, $prochaineBaliseFermanteA + 4); // +4 pour inclure la balise fermante </a>
            }
        }

        return $texteCoupe . ' ...';
    }
}