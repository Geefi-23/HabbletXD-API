<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  if (!$user->hasPermission(8)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar essa ação.' ]));
  }

  $data = json_decode(file_get_contents('php://input'));
  $db = DataBase::getInstance();

  $id = $data->id;
  $sql = "DELETE FROM compraveis WHERE id = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $id);
  $query->execute();

  echo json_encode([ 'success' => 'Comprável deletado com sucesso.' ])
?>