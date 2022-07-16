<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $sql = "SELECT id, imagem, destino FROM index_carousel";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($results);
?>