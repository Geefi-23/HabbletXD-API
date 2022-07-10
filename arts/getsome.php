<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $quantity = $_GET['quantity'];
  $sql = '';

  if (isset($_GET['user'])) {
    $sql = "SELECT p.*, c.nome AS `categoria_nome`, COUNT(pl.id) AS `likes`
    FROM pixel AS p
    INNER JOIN pixel_cat AS c
    ON c.id = p.categoria AND BINARY p.autor = ?
    LEFT JOIN pixel_likes AS pl
    ON p.url = pl.pixel_url
    GROUP BY p.id
    ORDER BY p.id DESC LIMIT ?";
    $query = $db->prepare($sql);
    $query->bindValue(1, $_GET['user']);
    $query->bindValue(2, $quantity, PDO::PARAM_INT);
  } else {
    $sql = "SELECT * FROM pixel ORDER BY id DESC limit ?";
    $query = $db->prepare($sql);
    $query->bindValue(1, $quantity, PDO::PARAM_INT);
  }

  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $artes = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([ 'success' => 'Artes encontradas com sucesso!', 'arts' => $artes ]); 
?>