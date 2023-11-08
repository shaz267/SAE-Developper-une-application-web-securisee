<?php

namespace touiteur\classes\Action;

use touiteur\classes\ConnectionFactory;

class PublierAction extends Action
{

    public function execute(): string
    {
        //un utilisateur rédige un touite et le publie sur la plateforme.

        if ($_SERVER['REQUEST_METHOD'] === 'GET'){

            return <<<END
            <h1>Publier un touite</h1>
            <form class="formulaireAuth" method='post' action='?action=PublierAction'>
            <label>Contenu : </label>
            <input type='text' name='touite' placeholder="Quoi de neuf ?!">
            <br><br>
            <button type='submit'>Publier</button>
            <br><br>
            </form>
            END;
        }
        else{

            $user = unserialize($_SESSION['user']);
            $id_user = $user->getIdUser();

            echo $id_user;

            $pdo = ConnectionFactory::makeConnection();
            $sql = "INSERT INTO touite (id_user, contenu, date_pub) VALUES ($id_user, '{$_POST['touite']}', NOW())";
            $stmt = $pdo->prepare($sql);
            var_dump($stmt);
            echo $sql;
            $stmt->execute();

            header("Location: ?action=MurAction");

            return '';

        }

    }
}