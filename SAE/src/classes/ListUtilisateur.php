<?php

namespace touiteur\classes;

class ListUtilisateur
{
    private array $utilisateurs =[];

    public function __construct(array $users =[]) {
        if(!empty($users)) {
            foreach ($users as $user) {
                if(!$user instanceof User) {
                    throw new InvalidArgumentException("La liste doit contenir uniquement des utilisateurs");
                }
            }
            $this->utilisateurs = $users;
        }
    }
    public function ajoutUtilisateur(User $u){
        $this->utilisateurs[] = $u;
    }

    public function supprUtilisateur(User $u) {
        $indice = array_search($u, $this->utilisateurs);
        if ($indice !== false) {
            unset($this->users[$indice]);
        } else {
            throw new InvalidUserException("L'user n'existe pas");
        }
    }

    public function __get(string $at):mixed {
        if (property_exists($this,$at)) return $this->$at;
        throw new InvalidPropertyNameException(get_called_class()." attribut invalid". $at);
    }
}