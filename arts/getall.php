<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $sql = "SELECT * FROM pixel ORDER BY id DESC";
  /*"SELECT n.*, c.nome AS `categoria_nome` 
  FROM noticias AS n
  INNER JOIN noticias_cat AS c
  ON c.id = n.categoria
  ORDER BY id DESC";*/
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>