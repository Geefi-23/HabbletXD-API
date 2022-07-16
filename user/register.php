<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;

  if (Authenticate::authenticate()){
    return print(json_encode([ 'error' => 'Você já está autenticado!' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $usuario = $data->nick;
  $senha = $data->senha;
  $date = time();
  $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

  if (!preg_match('/^[^\b]{5,40}$/', $usuario) || !preg_match('/^[^\b]{6,16}$/', $senha)){
    return print(json_encode([ 'error' => 'Os dados foram digitados incorretamente' ]));
  }
  $db = DataBase::getInstance();
  $sql = 'SELECT id FROM usuarios WHERE BINARY usuario = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  if (!empty($query->fetch())){
    return print(json_encode([ 'error' => 'Esta conta já existe em nosso sistema!' ]));
  }

  $sql = "INSERT INTO usuarios (usuario, senha, email, ultimo_data, ultimo_ip, dia_register, assinatura, missao, presenca, ultimo_dia) 
  VALUES (?, ?, '', ?, ?, ?, 'Sem assinatura', '', 0, '')";
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  $query->bindValue(2, md5($senha));
  $query->bindValue(3, $date);
  $query->bindValue(4, $ip);
  $query->bindValue(5, $date);
  try{
    $query->execute();
    echo json_encode([ 'success' => 'Você foi registrado com sucesso!' ]);
  } catch (PDOException $e) {
    echo json_encode([ 'error' => $e->errorInfo ]);
  }
?>