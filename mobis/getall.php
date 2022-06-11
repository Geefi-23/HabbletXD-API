<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $sql = "SELECT * FROM compraveis WHERE tipo = 'mobi'";
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>