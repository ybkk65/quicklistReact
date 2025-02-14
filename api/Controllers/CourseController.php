<?php

class CourseController {
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

            $courseModel = new CourseModel($bdd);
            $course = $courseModel->getAll();  // Appelle la méthode findById avec l'ID récupéré

            if ($course) {
                echo json_encode($course);  // Renvoie les données du personnage en JSON
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
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");

            $bdd = BDD::getInstance($this->config);

            $courseModel = new CourseModel($bdd);
            $course = $courseModel->deleteById($id);

            if ($course === true) {
                http_response_code(201);
                echo json_encode(["message" => "la liste de course avec l'id {$id} a été supprimer avec succès"]);
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["message" => "la liste de course avec l'id {$id} n'existe pas"]);
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
            empty($data['name']) ||
            !isset($data['items']) ||
            !is_array($data['items'])
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides ou incomplètes"]);
            exit;
        }

        foreach ($data['items'] as $item) {
            if (empty($item['name']) || !isset($item['quantity']) || $item['quantity'] <= 0) {
                http_response_code(400);
                echo json_encode(["message" => "Élément invalide ou quantité non valide"]);
                exit;
            }
        }

        try {
            $bdd = BDD::getInstance($this->config);

            $courseModel = new CourseModel($bdd);
            $courseModel->setName($data['name']);
            $courseModel->setItems($data['items']);

            $courseModel->add();

            http_response_code(201);
            echo json_encode(["message" => "Liste ajoutée avec succès"]);
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

