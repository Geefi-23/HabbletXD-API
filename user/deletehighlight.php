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

  $db = DataBase::getInstance();
  $user = $_GET['user'];

  $sql = "DELETE FROM usuarios_destaquesxd WHERE BINARY usuario = ?";
  $query = $db->prepare($sql);
  $query->execute([ $user ]);

  echo json_encode([ 'success' => 'Destaque deletado com sucesso.' ])
?>