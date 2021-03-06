<?php
  require 'utils/Headers.php';
  require './vendor/autoload.php';
    
  use Utils\DataBase;
  $q = $_GET['q'];

  $db = DataBase::getInstance();
  $sqlNoticias = "SELECT * from noticias WHERE titulo LIKE '%{$q}%' AND status = 'ativo'";
  $sqlUsuarios = "SELECT * from usuarios WHERE usuario LIKE '%{$q}%'";
  //$sqlArtes = "SELECT * from noticias WHERE titulo ~*'%{$q}'";
  $queryNoticias = $db->prepare($sqlNoticias);
  $queryUsuarios = $db->prepare($sqlUsuarios);

  $queryNoticias->execute();
  $queryUsuarios->execute();

  $resultNoticias = $queryNoticias->fetchAll(PDO::FETCH_ASSOC);
  $resultUsuarios = $queryUsuarios->fetchAll(PDO::FETCH_ASSOC);
  $results = array_merge($resultNoticias, $resultUsuarios);
  $count = sizeof($results);

  echo json_encode([ 'count' => $count, 'noticias' => $resultNoticias, 'usuarios' => $resultUsuarios ]);
?>