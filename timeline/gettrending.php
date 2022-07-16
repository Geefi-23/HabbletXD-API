<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  $db = DataBase::getInstance();

  $user = isset($_GET['user']) ? $_GET['user'] : '%%';

  $sql = "SELECT tag, COUNT(tag) AS count FROM forum_hashtags 
  WHERE BINARY usuario LIKE ?
  GROUP BY tag 
  ORDER BY count DESC";
  $query = $db->prepare($sql);
  $query->execute([ $user ]);
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode($results);
?>