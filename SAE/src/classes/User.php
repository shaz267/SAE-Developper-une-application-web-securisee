<?php

namespace touiteur\classes;

use touiteur\classes\Exceptions\InvalidArgumentException;

class User
{

    private $nom;
    private $prenom;
    private $email;
    private $mdp;
    private $droits;
    /**
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param int $role
     */
    public function __construct(string $nom, string $prenom, string $email){

        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    //get magic method
    /**
     * @throws InvalidArgumentException
     */
    public function __get(string $at):string {
        if (property_exists ($this, $at)) return $this->$at;
        throw new InvalidArgumentException("$at: invalid property");
    }



}