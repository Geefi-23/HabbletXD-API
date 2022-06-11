<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';

  $data = json_decode(file_get_contents('php://input'));

  $usuario = $data->usuario;

  $db = DataBase::getInstance();
  $sql = 'SELECT id, usuario, assinatura, twitter, missao FROM usuarios WHERE usuario = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível encontrar este usuário' ]));
  }
  $perfil = $query->fetch(PDO::FETCH_ASSOC);

  $sql = 'SELECT * FROM forum WHERE autor = ? ORDER BY id DESC limit 4';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível encontrar estas timelines' ]));
  }
  $timelines = $query->fetchAll(PDO::FETCH_ASSOC);

  if ($perfil) {
    echo json_encode([ 'success' => 'Usuário encontrado.', 'user' => [ 'info' => $perfil ]]);
  } else {
    echo json_encode([ 'error' => 'Este usuário não existe.' ]);
  }
?>