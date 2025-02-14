<?php

class Router{

  private $listRoutes;

  public function __construct(){
    if(!file_exists("routes/routes.json")){
      exit;
    }
    $stringRoutes = file_get_contents("routes/routes.json");
    $this->listRoutes = json_decode($stringRoutes);
  }

    public function findRoute($httpRequest, $basepath) {
        $url = str_replace($basepath, "", $httpRequest->getUrl());
        $method = $httpRequest->getMethod();

        $parsedUrl = parse_url($url);
        $queryParams = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';

        foreach ($this->listRoutes as $route) {
            $pattern = '#^' . preg_quote($route->path, '#');

            if (is_array($route->params)) {
                foreach ($route->params as $paramName) {
                    $pattern = str_replace("{" . $paramName . "}", '([^/]+)', $pattern);
                }
            }

            $pattern .= '$#';
            if (preg_match($pattern, $path, $matches)) {
                $params = [];
                if (is_array($route->params)) {
                    foreach ($route->params as $key => $paramName) {
                        if (isset($matches[$key + 1])) {
                            $params[$paramName] = $matches[$key + 1];
                        }
                    }
                }

                $params = array_merge($params, $queryParams);

                return new Route((object)[
                    'path' => $route->path,
                    'controller' => $route->controller,
                    'action' => $route->action,
                    'method' => $route->method,
                    'params' => $params,
                    'manager' => $route->manager
                ]);
            }
        }

        throw new Exception("Aucune route existante.");
    }

}