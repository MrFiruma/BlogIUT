<?php

class utilisateurs {

    /**
     *
     * @var integer
     */
    public ?int $id;

    /**
     * 
     *
     * @var string
     */
    public string $nom;
    
    /**
     * 
     *
     * @var string
     */
    public string $prenom;
    
    /**
     * 
     *
     * @var string
     */
    public string $email;
    
    /**
     * 
     *
     * @var string
     */
    public string $mdp;
    
    /**
     *
     * @var string
     */
    public string $sid;

    /**
     * 
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    public function getNom(): string {
        return $this->nom;
    }

    /**
     *
     * @return string
     */
    public function GetPrenom(): string {
        return $this->prenom;
    }

    /**
     *
     * @return string
     */
    public function Getemail(): string {
        return $this->email;
    }

    /**
     *
     * @return string
     */
    public function Getmdp(): string {
        return $this-> mdp;
    }

    /**
     *
     * @return string
     */
    public function getSid(): string {
        return $this-> sid;
    }

    /**
     * 
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param string $nom
     * @return self
     */
    public function setNom(string $nom): self {
        $this->nom = $nom;
        return $this;
    }

    /**
     *
     * @param string $prenom
     * @return self
     */
    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @param string $mdp
     * @return self
     */
    public function setMdp(string $mdp): self {
        $this->mdp = $mdp;
        return $this;
    }

    /**
     *
     * @param string $sid
     * @return self
     */
    public function setSid(string $sid): self {
        $this->sid = $sid;
        return $this;
    }

    public function hydrate(array $donnees): self {

        if (!empty($donnees['id'])) {
            $this->setId($donnees['id']);
        } else {
            $this->setId(null);
        }

        if (!empty($donnees['nom'])) {
            $this->setNom($donnees['nom']);
        } else {
            $this->setNom('');
        }

        if (!empty($donnees['prenom'])) {
            $this->setPrenom($donnees['prenom']);
        } else {
            $this->setPrenom('');
        }

        if (!empty($donnees['email'])) {
            $this->setEmail($donnees['email']);
        } else {
            $this->setEmail('');
        }

        if (!empty($donnees['mdp'])) {
            $this->setMdp($donnees['mdp']);
        } else {
            $this->setMdp('');
        }

        if (!empty($donnees['sid'])) {
            $this->setSid($donnees['sid']);
        } else {
            $this->setSid('');
        }

        return $this;

    }

}

?>