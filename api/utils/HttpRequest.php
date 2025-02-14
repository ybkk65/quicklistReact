<?php
class HttpRequest
{
    private $url;
    private $method;
    private $params;
    private $route;

    public function __construct($url = null, $method = null)
    {
        $this->url = is_null($url) ? $_SERVER["REQUEST_URI"] : $url;
        $this->method = is_null($method) ? $_SERVER["REQUEST_METHOD"] : $method;
        $this->params = [];
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function bindParam()
    {
        // Ajouter les paramètres extraits depuis la route
        foreach ($this->route->getParams() as $key => $value) {
            $this->addParam($key, $value);
        }

        // Traiter les paramètres GET ou POST selon la méthode HTTP
        switch ($this->method) {
            case "GET":
            case "DELETE":
                foreach ($_GET as $key => $value) {
                    $this->addParam($key, $value);
                }
                break;
            case "POST":
            case "PUT":
                foreach ($_POST as $key => $value) {
                    $this->addParam($key, $value);
                }
                break;
        }
    }

    public function run($config)
    {
        $this->bindParam();
        $this->route->run($this, $config);
    }
}
?>
