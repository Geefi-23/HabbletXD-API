<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;
  use Utils\AchievementHandler;

  if (!$user = Authenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $autor = $user['usuario'];
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
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  $timeline = $query->fetch(PDO::FETCH_ASSOC);

  // INSERE O COMENTÁRIO
  $sql = "INSERT INTO forum_comentarios(id_forum, autor, comentario, data)
  VALUES(?, ?, ?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $timeline['id']);
  $query->bindValue(2, $autor);
  $query->bindValue(3, $comentario);
  $query->bindValue(4, $date);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível registrar o comentário.' ]));
  }

  $res;
  if ($coins = AchievementHandler::saveAchievement($db, 3, $user['id']))
    $res = [ 'success' => 'Comentário salvo com sucesso!', 'award' => "Você ganhou {$coins} coins por comentar pela primeira vez em uma timeline!" ];
  else 
    $res = [ 'success' => 'Comentário salvo com sucesso!' ];

  echo json_encode($res);
?>