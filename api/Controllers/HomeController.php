<?php

class HomeController {
    private $httpRequest;
    private $config;

    public function __construct($httpRequest, $config) {
        $this->httpRequest = $httpRequest;
        $this->config = $config;
    }

    public function index() {
        echo "HOME PAGE";
    }
}
