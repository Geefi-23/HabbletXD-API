<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\DataBase;
  use Utils\Coins;

  if (!$user = Authenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  
  if (time() < (int) $user['artigo_delay']) {
    return print(
      json_encode([ 
        'error' => "Você postou um artigo recentemente e precisa aguardar 10 minutos até postar outra." 
      ]
    ));
  }

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $titulo = '';
  $autor = $user['usuario'];
  $texto = $data->texto;
  $hashtags = $data->hashtags;
  $data = time();
  $reviver = $data + (60*60*24*7);
  $moderado = 'nao';
  $moderador = '';
  $url = '';
  $fixo = 'nao';
  $status = 'ativo';
  $ip = $_SERVER['REMOTE_ADDR'];

  // validating hashtags
  foreach(explode(';', $hashtags) as $hashtag) {
    if (strpos($hashtag, ' '))
      return print(json_encode([ 'error' => 'Alguma das hashtags usadas não é valida.' ]));
  }

  while(true){
    $key = str_replace('=', '', base64_encode(random_int(0, 9999999)));
    
    $sql = 'SELECT * FROM noticias WHERE url = ?';
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

  $sql = "INSERT INTO forum(titulo, categoria, autor, texto, data, reviver, moderado, moderador, url, fixo, status, ip, hashtags) 
  VALUES(?, '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $query = $db->prepare($sql);
  $query->bindValue(1, $titulo);
  $query->bindValue(2, $autor);
  $query->bindValue(3, $texto);
  $query->bindValue(4, $data);
  $query->bindValue(5, $reviver);
  $query->bindValue(6, $moderado);
  $query->bindValue(7, $moderador);
  $query->bindValue(8, $url);
  $query->bindValue(9, $fixo);
  $query->bindValue(10, $status);
  $query->bindValue(11, $ip);
  $query->bindValue(12, str_replace(';', ' ', $hashtags));
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possivel salvar essa timeline.', 'details' => $e->errorInfo ]));
  }

  foreach(explode(';', $hashtags) as $hashtag) {
    if ($hashtag != '' AND strlen($hashtag) <= 84) {
      $sql = "INSERT INTO forum_Hashtags(usuario, tag, data) VALUES(?, ?, ?)";
      $query = $db->prepare($sql);
      $query->bindValue(1, $user['usuario']);
      $query->bindValue(2, $hashtag);
      $query->bindValue(3, time());

      $query->execute();
    }
  }

  $sql = "UPDATE usuarios SET artigo_delay = ? WHERE id = ?";
  $query = $db->prepare($sql);
  $query->execute([ time() + (60 * 10), $user['id'] ]);
  
  $res = [ 'success' => 'A timeline foi salva com sucesso!', 'url' => $url ];
  if ($coins = Coins::add($db, $user['id'], 10)) {
    $res['award'] = "Você ganhou {$coins} coins por criar sua primeira timeline na HabbletXD!";
    $res['coins'] = $coins;
  }

  echo json_encode($res)
?>