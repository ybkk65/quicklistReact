<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

class CourseModel {
    private $bdd;
    private $name;
    private $items;

    public function __construct($bdd = null) {
        if ($bdd !== null) {
            $this->setBdd($bdd);
        }
    }

    public function setBdd($bdd) {
        $this->bdd = $bdd;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }


    public function getAllProperties(): array {
        return [
            "name" => $this->getName(),
            "items" => $this->getItems(),
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
        SELECT * FROM liste WHERE id = :id
    ");

        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $this->setName($result['name']);
            $this->setItems($result['items']);

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

        $stmt = $this->bdd->query("SELECT * FROM liste");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        return $this->bdd->exec("DELETE FROM liste WHERE id={$id}");
    }

    public function updateById($id, $data) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }

        // Vérification des données
        if (empty($data['name']) || !isset($data['items']) || !is_array($data['items'])) {
            throw new Exception("Données invalides ou incomplètes.");
        }

        $itemsJson = json_encode($data['items']);

        $stmt = $this->bdd->prepare("
        UPDATE liste 
        SET name = :name, items = :items 
        WHERE id = :id
    ");

        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':items' => $itemsJson,
        ]);
    }

    public function add() {
        if (!$this->bdd) {
            throw new Exception("Base de données non initialisée.");
        }

        // Convertir les items en chaîne JSON
        $itemsJson = json_encode($this->getItems());

        $stmt = $this->bdd->prepare("
        INSERT INTO liste (name, items)
        VALUES (:name, :items)
    ");

        $stmt->execute([
            ':name' => $this->getName(),
            ':items' => $itemsJson,  // Stocker les items sous forme JSON
        ]);
    }




}


