<?php

ini_set("date.timezone", "Europe/Paris");
header('Access-Control-Allow-Origin: *'); // Permet l'accès depuis n'importe quel domaine
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Méthodes autorisées
header('Access-Control-Allow-Headers: Content-Type, Accept'); // En-têtes autorisés
header('Access-Control-Allow-Credentials: true'); // Si tu utilises des cookies ou des informations d'identification
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Accept');
    header('Access-Control-Allow-Credentials: true');
    exit;
}


require_once "./utils/Autoloader.php";
Autoloader::register();

$configManager = new Config();
[$configFile, $config] = $configManager->registerConfig();

try {
    $bdd = BDD::getInstance($config);
} catch (Exception $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

try {
    $httpRequest = new HttpRequest();
    $router = new Router();
    $httpRequest->setRoute($router->findRoute($httpRequest, $config->basepath));
    $httpRequest->run($config);
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}
