<?php
  require '../Utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));
  }

  if (!$user->hasPermission(10)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar esta ação.' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $destaque = $data->motivo;
  $usuario = $data->usuario;

  $db = DataBase::getInstance();

  $sql = "SELECT * FROM usuarios_destaquesxd";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll();
  if (sizeof($results) === 3) {
    return print(json_encode([ 'error' => 'Os destaques atingiram a capacidade máxima de 3, remova algum deles.' ]));
  }

  $sql = "SELECT id FROM usuarios WHERE BINARY usuario = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  $query->execute();

  if (!$query->fetch()) {
    return print(json_encode([ 'error' => 'Esse usuário não existe no banco de dados.' ]));
  }

  $sql = "INSERT INTO usuarios_destaquesxd(usuario, motivo) VALUES(?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  $query->bindValue(2, $destaque);
  try {
    $query->execute();
  } catch (PDOException $e) {
    http_response_code(401);
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Usuário destacado com sucesso.' ]);
  
?>