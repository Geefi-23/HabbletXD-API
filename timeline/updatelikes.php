<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;

  if (!$user = Authenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado' ]));
  }

  $db = DataBase::getInstance();

  $usuario_id = $user['id'];
  $forum_url = $_GET['key'];

  $sql = "SELECT usuario_id FROM forum_likes WHERE usuario_id = $usuario_id AND forum_url = '$forum_url'";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch();

  if ($result) // o usuario já deu like nesse post
    return;

  $sql = "INSERT INTO forum_likes(usuario_id, forum_url) VALUES(?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario_id);
  $query->bindValue(2, $forum_url);
  $query->execute();

  echo '{}'
?>