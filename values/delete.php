<?php
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;
  use Utils\MediaHandler;

  if (!$user = HPAuthenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));

  if (!$user->hasPermission(9))
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar esta ação.' ]));

  $db = DataBase::getInstance();
  $id = $_GET['id'];

  $sql = "DELETE FROM valores WHERE id = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $id);
  $query->execute();

  echo json_encode([ 'success' => 'Valor deletado com sucesso.' ])
?>