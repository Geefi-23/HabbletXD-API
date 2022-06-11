<?php
  require '../utils/Headers.php';
  require '../utils/Authentication.php';

  require '../config/DataBase.php';
  require '../utils/Token.php';

  authenticate();

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $id = $data->id;

  $sql = 'DELETE FROM noticias_comentarios WHERE id = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $id);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível deletar este comentário', 'details' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Comentário deletado com sucesso' ]);
?>