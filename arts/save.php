<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';
  require '../utils/Token.php';
  require '../utils/MediaHandler.php';

  if (!isset($_COOKIE['hxd-auth']) || !Token::isValid($_COOKIE['hxd-auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  $db = DataBase::getInstance();

  $data = json_decode($_POST['json']);

  $autorId = Token::decode($_COOKIE['hxd-auth'])[1]->sub;

  $sql = "SELECT usuario FROM usuarios WHERE id = ".$autorId;
  $query = $db->prepare($sql);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $user = $query->fetch(PDO::FETCH_ASSOC);

  $titulo = $data->titulo;
  $categoria = $data->categoria;
  $descricao = $data->descricao;
  $autor = $user['usuario'];
  $date = time();
  $ip = $_SERVER['REMOTE_ADDR'];
  $url;

  // URL GENERATOR
  while(true){
    $key = str_replace('=', '', base64_encode(random_int(0, 9999999)));
    
    $sql = 'SELECT * FROM pixel WHERE url = ?';
    $query = $db->prepare($sql);
    $query->bindValue(1, $key);
    try {
      $query->execute();
    } catch (PDOException $e) {
      return print(json_encode([ 'error' => $e->errorInfo ]));
    }

    if (empty($query->fetch())) {
      $url = $key;
      break;
    }
  }

  $imgdir= '';

  if ($titulo == '' || $categoria == '' || empty($_FILES['arte'])){
    return print(json_encode([ 'error' => 'Algum dos campos não foi preenchido' ]));
  }

  if (isset($_FILES['arte'])){
    $imgdir = MediaHandler::save($_FILES['arte'], 'arts');
  }

  $sql = "INSERT INTO pixel (titulo, categoria, descricao, imagem, autor, data, url, status, width, height, ip, tirinha)
  VALUES(?, ?, ?, ?, ?, ?, ?, 'sim', '', '', ?, 'nao')";
  $query = $db->prepare($sql);
  $query->bindValue(1, $titulo);
  $query->bindValue(2, $categoria);
  $query->bindValue(3, $descricao);
  $query->bindValue(4, $imgdir);
  $query->bindValue(5, $autor);
  $query->bindValue(6, $date);
  $query->bindValue(7, $url);
  $query->bindValue(8, $ip);
  $query->execute();

  echo json_encode([ 'success' => 'Arte publicada com sucesso' ]);
?>