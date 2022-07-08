<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();
  
  $sql = "SELECT * FROM compraveis";
  $query = $db->prepare($sql);
  $query->execute();
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>