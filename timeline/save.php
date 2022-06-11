<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';
  require '../utils/Token.php';
  require '../utils/AchievementHandler.php';

  if (!isset($_COOKIE['hxd-auth']) || !Token::isValid($_COOKIE['hxd-auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }
  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $decodedToken = Token::decode($_COOKIE['hxd-auth']);
  $userId = $decodedToken[1]->sub;

  $sql = "SELECT * FROM usuarios WHERE id = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $userId);
  $query->execute();
  $user = $query->fetch(PDO::FETCH_ASSOC);

  $titulo = '';
  $autor = $user['usuario'];
  $texto = $data->texto;
  $data = time();
  $reviver = $data + (60*60*24*7);
  $moderado = 'nao';
  $moderador = '';
  $url = '';
  $fixo = 'nao';
  $status = 'ativo';
  $ip = $_SERVER['REMOTE_ADDR'];

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

  $sql = "INSERT INTO forum(titulo, categoria, autor, texto, data, reviver, moderado, moderador, url, fixo, status, ip) 
  VALUES(?, '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possivel salvar essa timeline.', 'details' => $e->errorInfo ]));
  }
  
  $res;
  if (AchievementHandler::saveAchievement($db, 3, $user['id']))
    $res = [ 'success' => 'A timeline foi salva com sucesso!', 'award' => "Você ganhou {$coins} coins por criar sua primeira timeline na HabbletXD!" ];
  else 
    $res = [ 'success' => 'A timeline foi salva com sucesso!' ];
  echo json_encode($res)
?>