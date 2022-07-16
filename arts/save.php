<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;
  use Utils\MediaHandler;
  use Utils\Coins;

  if (!$user = Authenticate::authenticate()){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  if (time() < (int) $user['artigo_delay']) {
    return print(
      json_encode([ 'error' => "Você postou um artigo recentemente e precisa aguardar 10 minutos até postar outra." ]));
  }

  $db = DataBase::getInstance();

  $data = json_decode($_POST['json']);

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

  if ($titulo == '' || $categoria == '' || empty($_FILES['arte'])){
    return print(json_encode([ 'error' => 'Algum dos campos não foi preenchido' ]));
  }

  if (!isset($_FILES['arte'])){
    return print(json_encode([ 'error' => 'Você não enviou nenhuma imagem' ]));
  }

  $imgdir = MediaHandler::save($_FILES['arte'], 'arts');

  if (!$imgdir) {
    return print(json_encode([ 'error' => 'Não foi o possível salvar a sua arte. Verifique o formato da imagem.' ]));
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

  $sql = "UPDATE usuarios SET artigo_delay = ? WHERE id = ?";
  $query = $db->prepare($sql);
  $query->execute([ time() + (60 * 10), $user['id'] ]);

  $res = [ 'success' => 'Arte publicada com sucesso', 'url' => $url ];
  if ($coins = Coins::add($db, $user['id'], 10)) {
    $res['award'] = "Você ganhou {$coins} coins por publicar a sua primeira arte na HabbletXD!";
    $res['coins'] = $coins;
  }

  echo json_encode($res);
?>