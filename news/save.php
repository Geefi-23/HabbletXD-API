<?php
  require '../utils/Headers.php';
  
  require '../config/DataBase.php';
  require '../utils/PanelToken.php';
  require '../utils/MediaHandler.php';

  if (!isset($_COOKIE['hp_pages_auth']) || !PanelToken::isValid($_COOKIE['hp_pages_auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  $db = DataBase::getInstance();

  $data = json_decode($_POST['json']);

  $titulo = trim($data->titulo);
  $resumo = trim($data->resumo);
  $categoria = $data->categoria;
  $criador = $data->criador;
  $texto = $data->texto;
  $date = time();
  $url;

  // URL GENERATOR
  while(true){
    $key = str_replace('=', '', base64_encode(random_int(0, 9999)));
    $str = str_replace(' ', '-', strtolower(preg_replace('/[^A-Za-z ]/', '', $titulo)));
    
    $sql = 'SELECT * FROM noticias WHERE url = ?';
    $query = $db->prepare($sql);
    $query->bindValue(1, $str.$key);
    try {
      $query->execute();
    } catch (PDOException $e) {
      return print(json_encode([ 'error' => $e->errorInfo ]));
    }

    if (empty($query->fetch())) {
      $url = $str.$key;
      break;
    }
  }

  $imgdir= '';

  if ($titulo == '' || $resumo == '' || $texto == ''){
    return print(json_encode([ 'error' => 'Algum dos campos não foi preenchido' ]));
  }

  if (isset($_FILES['imagem'])){
    $imgdir = MediaHandler::save($_FILES['imagem'], 'images');
  }

  $sql = "INSERT INTO noticias(titulo, resumo, categoria, imagem, criador, url, texto, revisado, data, status, visualizacao, dia_evento, data_evento, `imagem-twitter`) 
  VALUES(?, ?, ?, ?, ?, ?, ?, '', ?, 'ativo', '0', '', '', '')";
  $query = $db->prepare($sql);
  $query->bindValue(1, $titulo);
  $query->bindValue(2, $resumo);
  $query->bindValue(3, $categoria);
  $query->bindValue(4, $imgdir);
  $query->bindValue(5, $criador);
  $query->bindValue(6, $url);
  $query->bindValue(7, $texto);
  $query->bindValue(8, $date);
  $query->execute();

  echo json_encode([ 'success' => 'Notícia postada com sucesso' ]);
?>