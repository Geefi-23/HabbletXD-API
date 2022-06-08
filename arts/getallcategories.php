<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $sql = 'SELECT id, nome, icone FROM pixel_cat';
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $categorias = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([ 'success' => 'Artes encontradas com sucesso!', 'categories' => $categorias ]);
?>