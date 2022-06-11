<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';
  require '../utils/Token.php';

  if (!isset($_COOKIE['hxd-auth']) || !Token::isValid($_COOKIE['hxd-auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $id = $data->id;

  $sql = 'DELETE FROM pixel_comentarios WHERE id = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $id);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível deletar este comentário', 'details' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Comentário deletado com sucesso' ]);
?>