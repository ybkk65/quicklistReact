<?php

class PersoModel {
    private $bdd;
    private $pseudo;
    private $title;
    private $job;
    private $stat_strength;
    private $stat_dexterity;
    private $stat_luck;
    private $stat_intelligence;
    private $stat_wisdom;

    public function __construct($bdd = null) {
        if ($bdd !== null) {
            $this->setBdd($bdd);
        }
    }

    public function setBdd($bdd) {
        $this->bdd = $bdd;
    }

    public function getPseudo() {
        return $this->pseudo;
    }

    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getJob() {
        return $this->job;
    }

    public function setJob($job) {
        $this->job = $job;
    }

    public function getStatStrength() {
        return $this->stat_strength;
    }

    public function setStatStrength($stat_strength) {
        $this->stat_strength = $stat_strength;
    }

    public function getStatDexterity() {
        return $this->stat_dexterity;
    }

    public function setStatDexterity($stat_dexterity) {
        $this->stat_dexterity = $stat_dexterity;
    }

    public function getStatLuck() {
        return $this->stat_luck;
    }

    public function setStatLuck($stat_luck) {
        $this->stat_luck = $stat_luck;
    }

    public function getStatIntelligence() {
        return $this->stat_intelligence;
    }

    public function setStatIntelligence($stat_intelligence) {
        $this->stat_intelligence = $stat_intelligence;
    }

    public function getStatWisdom() {
        return $this->stat_wisdom;
    }

    public function setStatWisdom($stat_wisdom) {
        $this->stat_wisdom = $stat_wisdom;
    }

    public function getAllProperties(): array {
        return [
            "pseudo" => $this->getPseudo(),
            "title" => $this->getTitle(),
            "class" => $this->getJob(),
            "stats" => [
                "strength" => $this->getStatStrength(),
                "dexterity" => $this->getStatDexterity(),
                "luck" => $this->getStatLuck(),
                "intelligence" => $this->getStatIntelligence(),
                "wisdom" => $this->getStatWisdom(),
            ]
        ];
    }

    public function getById($id) {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }

        $stmt = $this->bdd->prepare("
        SELECT * FROM persos WHERE id = :id
    ");

        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $this->setPseudo($result['pseudo']);
            $this->setTitle($result['title']);
            $this->setJob($result['job']);
            $this->setStatStrength($result['stat_strength']);
            $this->setStatDexterity($result['stat_dexterity']);
            $this->setStatLuck($result['stat_luck']);
            $this->setStatIntelligence($result['stat_intelligence']);
            $this->setStatWisdom($result['stat_wisdom']);

            return $this->getAllProperties();
        }

        return null;
    }

    public function getAll() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }

        $stmt = $this->bdd->query("SELECT * FROM persos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id) {
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }

        $checkStmt = $this->bdd->prepare("SELECT COUNT(*) FROM persos WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        $exists = $checkStmt->fetchColumn();

        if ($exists) {
            $stmt = $this->bdd->prepare("DELETE FROM persos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return true;
        }

        return false;
    }
    public function add() {
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }

        $stmt = $this->bdd->prepare("
            INSERT INTO persos (pseudo, title, job, stat_strength, stat_dexterity, stat_luck, stat_intelligence, stat_wisdom)
            VALUES (:pseudo, :title, :class, :stat_strength, :stat_dexterity, :stat_luck, :stat_intelligence, :stat_wisdom)
        ");

        $stmt->execute([
            ':pseudo' => $this->getPseudo(),
            ':title' => $this->getTitle(),
            ':class' => $this->getJob(),
            ':stat_strength' => $this->getStatStrength(),
            ':stat_dexterity' => $this->getStatDexterity(),
            ':stat_luck' => $this->getStatLuck(),
            ':stat_intelligence' => $this->getStatIntelligence(),
            ':stat_wisdom' => $this->getStatWisdom(),
        ]);
    }

    public function updateById($id, $data) {
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }
        $checkStmt = $this->bdd->prepare("SELECT COUNT(*) FROM persos WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        $exists = $checkStmt->fetchColumn();

        if ($exists) {
        $stmt = $this->bdd->prepare("
        UPDATE persos SET 
            pseudo = :pseudo, 
            title = :title, 
            job = :job, 
            stat_strength = :stat_strength, 
            stat_dexterity = :stat_dexterity, 
            stat_luck = :stat_luck, 
            stat_intelligence = :stat_intelligence, 
            stat_wisdom = :stat_wisdom
        WHERE id = :id
    ");

        $stmt->execute([
            ':id' => $id,
            ':pseudo' => $data['pseudo'],
            ':title' => $data['title'],
            ':job' => $data['class'],
            ':stat_strength' => $data['stats']['strength'],
            ':stat_dexterity' => $data['stats']['dexterity'],
            ':stat_luck' => $data['stats']['luck'],
            ':stat_intelligence' => $data['stats']['intelligence'],
            ':stat_wisdom' => $data['stats']['wisdom'],
        ]);
        return true;
        }

        return false;
    }

}


