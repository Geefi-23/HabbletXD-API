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
  $pixel_url = $_GET['key'];

  $sql = "SELECT usuario_id FROM pixel_likes WHERE usuario_id = $usuario_id AND pixel_url = '$pixel_url'";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch();

  if ($result) // o usuario já deu like nesse post
    return;

  $sql = "INSERT INTO pixel_likes(usuario_id, pixel_url) VALUES(?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario_id, PDO::PARAM_INT);
  $query->bindValue(2, $pixel_url);
  $query->execute();

  echo '{}';
?>