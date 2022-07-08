<?php
  require '../Utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;

  if (!$user = Authenticate::authenticate()) {
    http_response_code(401);
    return print(json_encode([ 'error' => 'Você não está autenticado.']));
  }
  
  $db = DataBase::getInstance();
  
  $codigo = $_GET['cod'];
  $usuario = $user['usuario'];
  $data = time();
  $sql = "SELECT id FROM presenca WHERE BINARY codigo = '$codigo'";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch();
  if ($result) {
    $sql = "INSERT INTO presenca_usado(id_cod, usuario, data) VALUES(?, ?, ?)";
    $query = $db->prepare($sql);
    $query->bindValue(1, $result['id']);
    $query->bindValue(2, $usuario);
    $query->bindValue(3, $data);
    $query->execute();

    http_response_code(200);
    return print(json_encode([ 'success' => 'Presença marcada com sucesso.' ]));
  }

  http_response_code(400);
  echo json_encode([ 'error' => 'Não foi possível marcar presença, talvez seu código seja inválido.' ]);
?>