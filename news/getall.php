<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  $db = DataBase::getInstance();

  $user = Authenticate::authenticate();

  $userid = $user ? $user['id'] : 0;

  $sql = "SELECT n.*, c.nome AS `categoria_nome`, c.icone AS `categoria_icone`, COUNT(nl.id) AS likes,
  CASE WHEN nr.id IS NULL THEN 0 ELSE 1 END AS `lido`
  FROM noticias AS n
  INNER JOIN noticias_cat AS c
  ON c.id = n.categoria
  LEFT JOIN noticias_likes AS nl
  ON n.url = nl.noticia_url
  LEFT JOIN noticias_lidos AS nr
  ON nr.usuario = ? AND nr.noticia_lida = n.url
  WHERE n.`status` = 'ativo' AND n.evento = 'nao'
  GROUP BY n.id 
  ORDER BY n.id DESC ";

  if (isset($_GET['limit']) && isset($_GET['offset'])) {
    $offset = $_GET['offset'];
    $limit = $_GET['limit'];
    $sql .= "LIMIT $limit OFFSET $offset";
  }
  
  $query = $db->prepare($sql);
  $query->bindValue(1, $userid);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
  //echo $from.':'.$limit;
?>