<?php

class PersoController {
    private $httpRequest;
    private $config;

    public function __construct($httpRequest, $config) {
        $this->httpRequest = $httpRequest;
        $this->config = $config;
    }

    public function GetAll()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }

        try {
            $bdd = BDD::getInstance($this->config);

            $persoModel = new PersoModel($bdd);
            $perso = $persoModel->getAll();  // Appelle la méthode findById avec l'ID récupéré

            if ($perso) {
                echo json_encode($perso);  // Renvoie les données du personnage en JSON
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Personnage non trouvé"]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur"]);
            exit;
        }
    }
    public function Get($id) {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }


        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "ID manquant"]);
            exit;
        }

        try {
            $bdd = BDD::getInstance($this->config);

            $persoModel = new PersoModel($bdd);
            $perso = $persoModel->getById($id);

            if ($perso) {
                echo json_encode($perso);
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Personnage non trouvé"]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur"]);
            exit;
        }
    }
    public function Delete($id) {

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }


        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "ID manquant"]);
            exit;
        }

        try {
            $bdd = BDD::getInstance($this->config);

            $persoModel = new PersoModel($bdd);
            $perso = $persoModel->deleteById($id);

            if ($perso === true) {
                http_response_code(201);
                echo json_encode(["message" => "le perso avec l'id {$id} a été supprimer avec succès"]);
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["message" => "le perso avec l'id {$id} n'existe pas"]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur"]);
            exit;
        }
    }
    public function Add() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (
            empty($data['pseudo']) ||
            empty($data['title']) ||
            empty($data['class']) ||
            !isset($data['stats']) ||
            !is_array($data['stats']) ||
            !isset($data['stats']['force'], $data['stats']['dexterity'], $data['stats']['luck'], $data['stats']['intelligence'], $data['stats']['knowledge'])
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides ou incomplètes"]);
            exit;
        }

        try {
            $bdd = BDD::getInstance($this->config);

            $persoModel = new PersoModel($bdd);
            $persoModel->setPseudo($data['pseudo']);
            $persoModel->setTitle($data['title']);
            $persoModel->setJob($data['class']);
            $persoModel->setStatStrength($data['stats']['force']);
            $persoModel->setStatDexterity($data['stats']['dexterity']);
            $persoModel->setStatLuck($data['stats']['luck']);
            $persoModel->setStatIntelligence($data['stats']['intelligence']);
            $persoModel->setStatWisdom($data['stats']['knowledge']);

            $persoModel->add();

            http_response_code(201);
            echo json_encode(["message" => "Personnage ajouté avec succès"]);
            exit;

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur"]);
            exit;
        }
    }

    public function Update($id) {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT");

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }

        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "ID manquant"]);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (
            empty($data['pseudo']) ||
            empty($data['title']) ||
            empty($data['class']) ||
            !isset($data['stats']) ||
            !is_array($data['stats']) ||
            !isset($data['stats']['strength'], $data['stats']['dexterity'], $data['stats']['luck'], $data['stats']['intelligence'], $data['stats']['wisdom'])
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides ou incomplètes"]);
            exit;
        }

        try {
            $bdd = BDD::getInstance($this->config);
            $persoModel = new PersoModel($bdd);
            $updated = $persoModel->updateById($id, $data);

            if ($updated) {
                http_response_code(200);
                echo json_encode(["message" => "Personnage mis à jour avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Personnage non trouvé ou aucune modification effectuée"]);
            }
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur"]);
            exit;
        }
    }

}

