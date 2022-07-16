<?php
  require '../utils/Headers.php';
  require '../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();
  $sql = "SELECT * FROM emblemas WHERE gratis = 'nao'";
  $query = $db->prepare($sql);
  $query->execute();
  $all = $query->fetchAll(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM emblemas WHERE gratis = 'sim'";
  $query = $db->prepare($sql);
  $query->execute();
  $free = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([ 'all' => $all, 'free' => $free ]);
?>