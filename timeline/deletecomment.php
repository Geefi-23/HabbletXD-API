<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  if (!$user = Authenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
    
  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $usuario = $user['usuario'];
  $id_comentario = $data->id;

  $sql = "SELECT autor FROM forum_comentarios WHERE id = $id_comentario AND BINARY autor = '$usuario'";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch();
  
  if (!$result)
    return print(json_encode([ 'error' => 'Este comentário não existe ou você não tem permissão para deleta-lo.' ]));

  $sql = "DELETE FROM forum_comentarios WHERE id = $id_comentario";
  $query = $db->prepare($sql);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Comentário deletado com sucesso' ]);
?>