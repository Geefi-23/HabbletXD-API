<?php

  header('Access-Control-Allow-Origin: http://localhost:3000');
  header('Access-Control-Allow-Header: Content-Type');

  require '../config/DataBase.php';
  require '../utils/Token.php';

  if (isset($_COOKIE['hxd-auth']) && Token::isValid($_COOKIE['hxd-auth'])){
    return print(json_encode([ 'error' => 'Você já está autenticado!' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $usuario = $data->nick;
  $senha = $data->senha;
  $missao = $data->missao;
  $date = time();
  $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

  if (!preg_match('/^[A-Za-z0-9 ]{5,40}$/', $usuario) || !preg_match('/^[^\b]{6,16}$/', $senha)){
    return print(json_encode([ 'error' => 'Os dados foram digitados incorretamente' ]));
  }
  $db = DataBase::getInstance();
  $sql = 'SELECT id FROM usuarios WHERE usuario = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível fazer o registro.' ]));
  }
  if (!empty($query->fetch())){
    return print(json_encode([ 'error' => 'Esta conta já existe em nosso sistema!' ]));
  }

  $sql = "INSERT INTO usuarios (usuario, senha, email, ultimo_data, ultimo_ip, dia_register, assinatura, missao, presenca) 
  VALUES (?, ?, '', ?, ?, ?, 'Sem assinatura', ?, 0)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  $query->bindValue(2, md5($senha));
  $query->bindValue(3, $date);
  $query->bindValue(4, $ip);
  $query->bindValue(5, $date);
  $query->bindValue(6, $missao);
  try{
    $query->execute();
    echo json_encode([ 'success' => 'Você foi registrado com sucesso!' ]);
  } catch (PDOException $e) {
    echo json_encode([ 'error' => 'Não foi possível fazer o registro.' ]);
  }
?>