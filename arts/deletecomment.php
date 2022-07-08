<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';
  
  use Utils\Authenticate;
  use Utils\DataBase;

  if (!$user = Authenticate::authenticate()){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $usuario = $user['usuario'];
  $id_comentario = $data->id;

  $sql = "SELECT autor FROM pixel_comentarios WHERE id = $id_comentario AND BINARY autor = '$usuario'";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch();
  
  if (!$result)
    return print(json_encode([ 'error' => 'Este comentário não existe ou você não tem permissão para deleta-lo.' ]));

  $sql = 'DELETE FROM pixel_comentarios WHERE id = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $id_comentario);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível deletar este comentário', 'details' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Comentário deletado com sucesso' ]);
?>