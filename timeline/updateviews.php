<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;


  if (!Authenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado' ]));
  }

  $db = DataBase::getInstance();

  $key = $_GET['key'];

  $sql = 'SELECT visualizacao FROM forum WHERE url = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $key);
  try {
    $query->execute();
  } catch (PDOException $e) {
    print(json_encode([ 'error' => 'erro', 'details' => $e->errorInfo ]));
  }
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $views = $result['visualizacao'];
  $views += 1;

  $sql = 'UPDATE forum SET visualizacao = ? WHERE url = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $views);
  $query->bindValue(2, $key);
  try {
    $query->execute();
  } catch (PDOException $e) {
    print(json_encode([ 'error' => 'erro', 'details' => $e->errorInfo ]));
  }
?>