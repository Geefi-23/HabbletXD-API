<?php
  require '../utils/Headers.php';
  require '../utils/Authentication.php';

  require '../config/DataBase.php';
  require '../config/Token.php';

  authenticate();

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $url = $data->url;

  $sql = 'DELETE FROM noticias WHERE url = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível deletar esta notícia', 'details' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Noticia deletada com sucesso' ]);
?>