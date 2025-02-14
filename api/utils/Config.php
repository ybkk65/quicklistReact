<?php
class Config{

  private $configFile;
  private $config;

  public function __construct($configPath = "config/config.json"){
    if(!file_exists($configPath)){
      exit;
    }

    $this->registerConfig($configPath);
  }

  public function getConfigFile(){
    return $this->configFile;
  }

  public function getConfig(){
    return $this->config;
  }

  public function registerConfig($configPath = "config/config.json"){
    $this->configFile = file_get_contents($configPath);
    $this->config = json_decode($this->configFile);

    return [$this->configFile, $this->config];
  }

}