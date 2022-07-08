<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $sql = 'SELECT id, nome, icone FROM pixel_cat';
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $categorias = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($categorias);
?>