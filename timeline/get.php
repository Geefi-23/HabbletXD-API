<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  $db = DataBase::getInstance();

  $url = $_GET['key'];

  $liked;
  if ($user = Authenticate::authenticate()) { // se estiver autenticado, vai checar se já deu like nesse post
    $sql = "SELECT id FROM forum_likes WHERE forum_url = ? AND usuario_id = ?";
    $query = $db->prepare($sql);
    $query->bindValue(1, $url);
    $query->bindValue(2, intval($user['id']), PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
      $liked = 0;
    } else {
      $liked = 1;
    }
  } else {
    $liked = 0;
  }

  $sql = "SELECT f.*, COUNT(fl.usuario_id) AS likes, $liked AS liked FROM forum AS f
        LEFT JOIN forum_likes AS fl
        ON fl.forum_url = f.url
        WHERE f.url = ?
        GROUP BY f.id
        ORDER BY f.id DESC";
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $timeline = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM forum_comentarios WHERE id_forum = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $timeline['id']);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $comments = $query->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode([ 'success' => 'Timeline encontrada com sucesso!', 'object' => $timeline, 'comentarios' => $comments, 'liked' => $liked ]); 
?>