<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';
  require '../utils/Token.php';

  $data = json_decode(file_get_contents('php://input'));

  $usuario = $data->nick;
  $senha = md5($data->senha);

  $db = DataBase::getInstance();
  $sql = 'SELECT * FROM usuarios WHERE usuario = ? AND senha = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  $query->bindValue(2, $senha);
  try {
    $query->execute();
  } catch (PDOException $e) {
    echo $e->errorInfo;
  }
  $result = $query->fetch(PDO::FETCH_ASSOC);
  if (empty($result)){
    return print(json_encode([ 'error' => 'Usuário ou senha estão incorretos!' ]));
  }

  $date = time();
  $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
  $sql = 'UPDATE usuarios SET ultimo_data = ?, ultimo_ip = ? WHERE id = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $date);
  $query->bindValue(2, $ip);
  $query->bindValue(3, $result['id']);
  try {
    $query->execute();
  } catch (PDOException $e) {
    echo $e->errorInfo;
  }

  $token = Token::create($result['id']);
  $user = [
    "usuario" => $result['usuario'],
    "twitter" => $result['twitter'],
    "avatar" => $result['avatar'],
    "missao" => $result['missao'],
    "avatar" => $result['avatar']
  ];

  $sql = 'SELECT * FROM forum WHERE autor = ? ORDER BY id DESC limit 4';
  $query = $db->prepare($sql);
  $query->bindValue(1, $user['usuario']);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível encontrar estas timelines' ]));
  }
  $timelines = $query->fetchAll(PDO::FETCH_ASSOC);

  header("Set-Cookie: __Host-habbletxd_auth={$token}; path=/; Secure; HttpOnly; expires="+time() + 3600 * 24 * 7); // expira em uma semana
  return print(json_encode([ 'success' => 'Logado!', 'user' => [ 'info' => $user, 'timelines' => $timelines ]]));
?>