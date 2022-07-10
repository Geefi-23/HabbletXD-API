<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPDataBase;

  $data = json_decode(file_get_contents('php://input'));

  $usuario = $data->usuario;

  $db = DataBase::getInstance();
  $sql = 'SELECT id, usuario, assinatura, twitter, missao, avatar FROM usuarios WHERE BINARY usuario = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível encontrar este usuário' ]));
  }
  $perfil = $query->fetch(PDO::FETCH_ASSOC);

  $db = HPDataBase::getInstance();
  $sql = "SELECT c.nome AS `cargo` FROM hp_cargos AS c
    INNER JOIN hp_users AS u
    ON u.cargo = c.id AND BINARY u.nome = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $result = $query->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $perfil['cargo'] = $result['cargo'];
  } else {
    $perfil['cargo'] = 'Não é membro';
  }

  if ($perfil) {
    echo json_encode([ 'success' => 'Usuário encontrado.', 'user' => $perfil ]);
  } else {
    echo json_encode([ 'error' => 'Este usuário não existe.' ]);
  }
?>