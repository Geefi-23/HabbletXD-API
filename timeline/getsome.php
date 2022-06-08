<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $quantity = $_GET['quantity'];
  $sql = '';

  if (isset($_GET['user'])) {
    $sql = "SELECT * FROM forum WHERE autor = ? ORDER BY id DESC limit ?";
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