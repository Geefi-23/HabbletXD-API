<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $sql = "SELECT p.*, c.nome AS `categoria_nome`, COUNT(pl.id) AS `likes`
  FROM pixel AS p
  INNER JOIN pixel_cat AS c
  ON c.id = p.categoria
  LEFT JOIN pixel_likes AS pl
  ON p.url = pl.pixel_url
  GROUP BY p.id
  ORDER BY p.id DESC";
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>