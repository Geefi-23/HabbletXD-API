<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';
  
  use Utils\Authenticate;

  print(json_encode([ 'authenticated' => Authenticate::authenticate() ]));
?>