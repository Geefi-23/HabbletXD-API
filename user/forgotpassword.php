<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  if ($user = Authenticate::authenticate())
    return print(json_encode([ 'error' => 'Você já está autenticado.' ]));
  
  $id = $user['id'];

  
?>