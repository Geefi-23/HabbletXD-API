<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $sql = "SELECT n.*, c.nome AS `categoria_nome` 
  FROM noticias AS n
  INNER JOIN noticias_cat AS c
  ON c.id = n.categoria
  WHERE n.`status` = 'ativo'
  ORDER BY n.id DESC";
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>