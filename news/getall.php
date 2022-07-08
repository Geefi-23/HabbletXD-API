<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  

  $db = DataBase::getInstance();

  $sql = "SELECT n.*, c.nome AS `categoria_nome`, c.icone AS `categoria_icone`, COUNT(nl.id) AS likes
  FROM noticias AS n
  INNER JOIN noticias_cat AS c
  ON c.id = n.categoria
  LEFT JOIN noticias_likes AS nl
  ON n.url = nl.noticia_url
  WHERE n.`status` = 'ativo' AND n.evento = 'nao'
  GROUP BY n.id
  ORDER BY n.id DESC";
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>