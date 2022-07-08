<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $sql = "SELECT f.*, COUNT(distinct fl.id) AS likes FROM forum AS f
        LEFT JOIN forum_likes AS fl
        ON f.url = fl.forum_url
        WHERE f.fixo = 'nao'
        GROUP BY f.id
        ORDER BY f.id DESC";
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>