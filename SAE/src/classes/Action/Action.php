<?php

namespace touiteur\classes\Action;
;
abstract class Action
{

    protected $http_method = null;
    protected $hostname = null;
    protected $script_name = null;

    public function __construct()
    {

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    abstract public function execute(): string;

    /**
     * Fonction qui permet de retourner le code HTML pour afficher les touites
     * @param array $touites
     * @return string
     */
    public static function renderTouites(array $touites): string
    {

        $html = "";
        //On parcourt les touites
        foreach ($touites as $touite) {

            //On convertit le contenu en UTF-8
            $touite['contenu'] = utf8_encode($touite['contenu']);

            //On réduit le contenu pour l'afficher en version courte
            $touite['contenu'] = substr($touite['contenu'], 0, 40) . ' ...';

            $html .= <<<HTML
            <div class="touite" onclick="location.href='?action=TouiteDetailAction&touite_id={$touite['id_touite']}'">
                <a href="?action=TouitesPersonneAction&id={$touite['id_user']}"><h3>{$touite['nom']} {$touite['prenom']}</h3></a>
                <br>
                <p>{$touite['contenu']}</p>
                <br>
                <p>Date du post : {$touite['date_pub']}</p>
                <br>
            </div>
            HTML;
        }
        //On retourne le code HTML
        return $html;
    }
}