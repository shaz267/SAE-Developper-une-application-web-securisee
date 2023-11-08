<?php

namespace touiteur\classes;

class User
{

    private string $pseudo;
    private string $nom;
    private string $email;
    private string $mdp;
    protected int $role; //role de l'utilisateur

    private ListUser $abonnements; //liste des abonnements du membre
    private ListUser $abonnés; //liste des abonnés du membre

    /**
     * @param mixed $nom
     * @param mixed $prenom
     * @param string $email
     * @param mixed $role
     */
    public function __construct($nom, $prenom, string $email, $role){

        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
    }
}