<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

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
    public function Get(...$params) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit;
        }

        $id = $params["id"];

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

            $persoModel = new CourseModel($bdd);
            $perso = $persoModel->getById($id);

            if ($perso) {
                echo json_encode($perso);
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["message" => "liste course non trouvé"]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur"]);
            exit;
        }
    }
    public function Delete(...$params)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }

        $id = $params["id"];

        try {
            $bdd = BDD::getInstance($this->config);
            $courseModel = new CourseModel($bdd);

            if (!$courseModel->getById($id)) {
                http_response_code(404);
                echo json_encode(["message" => "Liste de course non trouvée"]);
                exit;
            }

            if ($courseModel->deleteById($id)) {
                http_response_code(200);
                echo json_encode(["message" => "Liste de course n°{$id} supprimée avec succès"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Échec de la suppression"]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur", "error" => $e->getMessage()]);
        }
        exit;
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
    public function Update() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT");

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(["message" => "Méthode non autorisée"]);
            exit;
        }

        // Récupération des données envoyées
        $data = json_decode(file_get_contents('php://input'), true);
        $id = isset($data['id']) ? $data['id'] : null;

        if ($id === null) {
            http_response_code(400);
            echo json_encode(["message" => "ID manquant"]);
            exit;
        }

        if (empty($data['name']) || !isset($data['items']) || !is_array($data['items'])) {
            http_response_code(400);
            echo json_encode(["message" => "Données invalides ou incomplètes"]);
            exit;
        }

        try {
            $bdd = BDD::getInstance($this->config);
            $courseModel = new CourseModel($bdd);
            $updated = $courseModel->updateById($id, $data);

            if ($updated) {
                http_response_code(200);
                echo json_encode(["message" => "Liste mise à jour avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Liste non trouvée ou aucune modification effectuée"]);
            }
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Erreur interne du serveur", "error" => $e->getMessage()]);
            exit;
        }
    }


}

