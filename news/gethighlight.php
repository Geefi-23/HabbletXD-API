<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  $db = DataBase::getInstance();
  
  $sql = "SELECT id, titulo, resumo FROM noticias WHERE destaque = 'sim'";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);

  echo json_encode($result);
?>