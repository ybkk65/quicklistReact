<?php

class Autoloader{

  public static function register(){
    spl_autoload_register(function ($class){
      $configFile = file_get_contents("config/config.json");
      $config = json_decode($configFile);
      $class = ucfirst($class);
      foreach($config->autoloadFolder as $folder){
        if(file_exists("{$folder}/{$class}.php")){
          require_once "{$folder}/{$class}.php";
          break;
        }
      }
    });
  }

}