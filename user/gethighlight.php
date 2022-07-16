<?php
  require '../Utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();
  $sql = "SELECT d.usuario, d.motivo FROM usuarios_destaquesxd AS d 
  INNER JOIN usuarios AS u
  ON BINARY u.usuario = d.usuario";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode($results);
?>