<?php

class BDD {
    private $bdd;
    private static $instance;

    public function __construct($bddConfig = null)
    {
        if (is_null($bddConfig)) {
            $configManager = new Config();
            $config = $configManager->getConfig();
        } else {
            $config = $bddConfig;
        }

        try {
            $this->bdd = new PDO(
                "mysql:dbname={$config->database->name};host={$config->database->host};charset=utf8;",
                $config->database->username,
                $config->database->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getInstance($bddConfig = null): PDO
    {
        if (empty(self::$instance)) {
            self::$instance = new BDD($bddConfig);
        }
        return self::$instance->bdd;
    }

    public function getBdd(): PDO
    {
        return $this->bdd;
    }
}
