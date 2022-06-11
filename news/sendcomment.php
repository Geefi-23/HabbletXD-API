<?php
  require '../utils/Headers.php';
  require '../utils/Authentication.php';

  require '../config/DataBase.php';
  require '../utils/Token.php';
  require '../utils/AchievementHandler.php';

  authenticate();

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $userid = Token::decode($_COOKIE['hxd-auth'])[1]->sub;

  $sql = "SELECT id, usuario FROM usuarios WHERE id = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $userid);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível registrar o comentário.', 'details' => $e->errorInfo ]));
  }
  
  $autor = $query->fetch(PDO::FETCH_ASSOC);
  $url = $data->url;
  $comentario = $data->comentario;
  $date = time();

  if (preg_match('/^[ \n]*$/', $comentario)) {
    return print(json_encode([ 'error' => 'Comentário vazio.' ]));
  }

  $sql = "SELECT * FROM noticias WHERE url = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível registrar o comentário.', 'details' => $e->errorInfo ]));
  }

  $news = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "INSERT INTO noticias_comentarios(id_noticia, autor, comentario, data)
  VALUES(?, ?, ?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $news['id']);
  $query->bindValue(2, $autor['usuario']);
  $query->bindValue(3, $comentario);
  $query->bindValue(4, $date);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível registrar o comentário.' ]));
  }

  $res;
  if ($coins = AchievementHandler::saveAchievement($db, 1, $autor['id']))
    $res = [ 'success' => 'Comentário salvo com sucesso!', 'award' => "Você ganhou {$coins} coins por comentar pela primeira vez!!" ];
  else 
    $res = [ 'success' => 'Comentário salvo com sucesso!' ];

  echo json_encode($res);
?>