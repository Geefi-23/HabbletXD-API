<?php
  require '../Utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));
  }

  if (!$user->hasPermission(10)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar esta ação.' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $destaque = $data->destaque;
  $usuario = $data->usuario;

  $db = DataBase::getInstance();
  $sql = "UPDATE usuarios SET destaque = '$destaque' WHERE BINARY usuario = '$usuario'";
  $query = $db->prepare($sql);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  
?>