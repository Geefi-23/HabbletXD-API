<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $url = $_GET['key'];
  $sql = "SELECT * FROM forum WHERE url = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  $timeline = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM forum_comentarios WHERE id_forum = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $timeline['id']);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro' ]));
  }
  $comments = $query->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode([ 'success' => 'Timeline encontrada com sucesso!', 'object' => $timeline, 'comentarios' => $comments ]); 
?>