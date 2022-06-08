<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');
  header('Access-Control-Allow-Credentials: true');

  require '../config/DataBase.php';
  require '../utils/Token.php';
  require '../utils/AchievementHandler.php';

  if (!isset($_COOKIE['hxd-auth']) || !Token::isValid($_COOKIE['hxd-auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $userid = Token::decode($_COOKIE['hxd-auth'])[1]->sub;

  // PEGA O NOME DO AUTOR DO COMENTÁRIO
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

  // PEGA A TIMELINE NO QUAL O COMENTÁRIO FOI ENVIADO
  $sql = "SELECT * FROM forum WHERE url = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível registrar o comentário.', 'details' => $e->errorInfo ]));
  }

  $timeline = $query->fetch(PDO::FETCH_ASSOC);

  // INSERE O COMENTÁRIO
  $sql = "INSERT INTO forum_comentarios(id_forum, autor, comentario, data)
  VALUES(?, ?, ?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $timeline['id']);
  $query->bindValue(2, $autor['usuario']);
  $query->bindValue(3, $comentario);
  $query->bindValue(4, $date);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível registrar o comentário.' ]));
  }

  $res;
  if ($coins = AchievementHandler::saveAchievement($db, 3, $autor['id']))
    $res = [ 'success' => 'Comentário salvo com sucesso!', 'award' => "Você ganhou {$coins} coins por comentar pela primeira vez em uma timeline!" ];
  else 
    $res = [ 'success' => 'Comentário salvo com sucesso!' ];

  echo json_encode($res);
?>