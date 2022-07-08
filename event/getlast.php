<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $sql = "SELECT n.id, n.titulo, n.resumo, c.nome AS `categoria`, c.icone AS `categoria_icone`, n.imagem, 
  n.criador, n.data, n.url, n.visualizacao, n.texto, COUNT(nl.id) AS `likes`, 0 AS `liked`
  FROM noticias AS n
  INNER JOIN noticias_cat AS c
  ON c.id = n.categoria
  LEFT JOIN noticias_likes AS nl
  ON n.url = nl.noticia_url
  WHERE n.status = 'ativo' AND n.evento = 'sim'
  GROUP BY n.id
  ORDER BY n.id DESC LIMIT 1";

  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);

  echo json_encode($result);
?>