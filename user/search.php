<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  
  $data = json_decode(file_get_contents('php://input'));
  
  $value = $data->value;

  $db = DataBase::getInstance();
  $sql = "SELECT id, usuario FROM usuarios WHERE BINARY usuario LIKE '%$value%'";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($results);
?>