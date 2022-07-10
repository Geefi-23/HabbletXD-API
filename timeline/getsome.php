<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $quantity = $_GET['quantity'];
  $sql = '';

  if (isset($_GET['user'])) {
    $sql = "SELECT f.*, COUNT(distinct fl.id) AS likes FROM forum AS f
    LEFT JOIN forum_likes AS fl
    ON f.url = fl.forum_url
    WHERE f.fixo = 'nao' AND BINARY f.autor = ?
    GROUP BY f.id
    ORDER BY f.id DESC LIMIT ?";
    $query = $db->prepare($sql);
    $query->bindValue(1, $_GET['user']);
    $query->bindValue(2, $quantity, PDO::PARAM_INT);
  } else {
    $sql = "SELECT * FROM forum ORDER BY id DESC limit ?";
    $query = $db->prepare($sql);
    $query->bindValue(1, $quantity, PDO::PARAM_INT);
  }

  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $timelines = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([ 'success' => 'Timelines encontradas com sucesso!', 'timelines' => $timelines ]); 
?>