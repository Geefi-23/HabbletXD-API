<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();
  $sql = "SELECT COUNT(id) AS count FROM noticias WHERE status = 'ativo'";
  $query = $db->prepare($sql);
  $query->execute();

  echo json_encode($query->fetch(PDO::FETCH_ASSOC));
?>