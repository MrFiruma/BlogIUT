<?php

class articlesManager {

    /**
     * 
     * @var PDO
     */
    private PDO $bdd;

    /**
     * 
     * @var bool|null
     */
    private ?bool $_result;

    /**
     * 
     * @var articles
     */
    private articles $_article;

    /**
     * 
     * @var int
     */
    private int $_getLastInsertId;

    /**
     * 
     * @return PDO
     */
    public function getBdd(): PDO {
        return $this->bdd;
    }

    /**
     * 
     * @return bool|null
     */
    public function get_result(): ?bool {
        return $this->_result;
    }

    /**
     * 
     * @return articles
     */
    public function get_article(): articles {
        return $this->_article;
    }

    /**
     * 
     * @return int
     */
    public function get_getLastInsertId(): int {
        return $this->_getLastInsertId;
    }

    /**
     * 
     * @param PDO $bdd
     * @return self
     */
    public function setBdd(PDO $bdd): self {
        $this->bdd = $bdd;
        return $this;
    }

    /**
     * 
     * @param bool|null $_result
     * @return self
     */
    public function set_result(?bool $_result): self {
        $this->_result = $_result;
        return $this;
    }

    /**
     * 
     * @param articles $_article
     * @return self
     */
    public function set_article(articles $_article): self {
        $this->_article = $_article;
        return $this;
    }

    /**
     * 
     * @param int $_getLastInsertId
     * @return self
     */
    public function set_getLastInsertId(int $_getLastInsertId): self {
        $this->_getLastInsertId = $_getLastInsertId;
        return $this;
    }

    /**
     * 
     * @param PDO $bdd
     */
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }

    // Fonction qui permet de récuperer l'objet article en fonction de son ID
    /**
     * Fonction qui permet de récupérer l'objet article en fonction de son ID
     *
     * @param integer $id
     * @return void
     */
    public function getListId(int $id) {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id
        $sql = 'SELECT * FROM articles WHERE id = :id';
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $articles = new articles();
        $articles->hydrate($donnees);
        //print_r2($articles);
        return $articles;
    }

    /**
     * 
     * @return array
     */
    public function getList(): array {
        $listArticle = [];

        // Prépare une requête de type SELECT
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }

    /**
     * 
     * @param articles $articles
     * @return $this
     */
    public function add(articles $articles) {
        $sql = "INSERT INTO articles "
                . "(titre, texte, publie, date) "
                . "VALUES (:titre, :texte, :publie, :date)";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);
        $req->bindValue(':date', $articles->getDate(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    /**
     * fonction qui ajoute un commentaire à l'article
     *
     * @param articles $articles
     * @return void
     */
    public function addComm(articles $articles) {
        $sql = "UPDATE articles SET "
                . "prenom = :prenom, "
                . "commentaire = :commentaire, ";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':prenom', $articles->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':commentaire', $articles->getCommentaire(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            // $this->_getLastInsertId = $articles->getId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    /**
     * Fonction qui met à jour un article en BDD
     *
     * @param articles $articles
     * @return void
     */
    public function update(articles $articles) {
        $sql = "UPDATE articles SET "
                . "titre = :titre, "
                . "texte = :texte, "
                . "publie = :publie "
                . "WHERE id = :id";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_STR);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            // $this->_getLastInsertId = $articles->getId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    /**
     * fonction qui supprime un article
     *
     * @param articles $articles
     * @return void
     */
    public function delete(articles $articles) {
        $sql = "DELETE FROM articles WHERE id = :id";
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_STR);
        $req->execute();
        //execution de la requête
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            // $this->_getLastInsertId = $articles->getId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    /**
     * 
     * @return int
     */
    public function countArticles(): int {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }

    /**
     * 
     * @param int $depart
     * @param int $limit
     * @return array
     */
    public function getListArticlesAAfficher(int $depart, int $limit): array {
        $listArticle = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles '
                . 'LIMIT :depart, :limit';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }

    /**
     * Fonction qui récupère la liste d'article selon un mot clé
     *
     * @param [type] $recherche
     * @return void
     */
    public function getListArticlesFromRecherche($recherche) {
        $listArticle = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles '
                . 'WHERE (titre LIKE :recherche '
                . 'OR texte LIKE :recherche)';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }
}