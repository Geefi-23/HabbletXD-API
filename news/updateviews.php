<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $key = $_GET['key'];

  $sql = 'SELECT visualizacao FROM noticias WHERE url = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $key);
  try {
    $query->execute();
  } catch (PDOException $e) {
    print(json_encode([ 'error' => 'erro', 'details' => $e->errorInfo ]));
  }
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $views = intval($result['visualizacao']);
  $views += 1;

  $sql = 'UPDATE noticias SET visualizacao = ? WHERE url = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $views);
  $query->bindValue(2, $key);
  try {
    $query->execute();
  } catch (PDOException $e) {
    print(json_encode([ 'error' => 'erro', 'details' => $e->errorInfo ]));
  }
?>