<?php
  header('Access-Control-Allow-Origin: https://localhost');
  header('Access-Control-Allow-Headers: Set-Cookie, Content-Type');
  header('Access-Control-Allow-Credentials: true');
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;
  use Utils\MediaHandler;
  
  if (!$user = HPAuthenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  if (!$user->hasPermission(8)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar essa ação.' ]));
  }

  $db = DataBase::getInstance();

  $data = json_decode($_POST['data']);

  if (!isset($_FILES['imagem'])) {
    return print(json_encode([ 'error' => 'Você não pode postar um comprável sem uma imagem.' ]));
  }

  $nome = $data->nome;
  $tipo = $data->tipo;
  $valor = $data->valor;
  $time = time();
  $imagem = MediaHandler::save($_FILES['imagem'], 'buyables');

  $sql = "INSERT INTO `compraveis`(nome, tipo, valor, promocao, imagem, gratis, data) 
      VALUES(?, ?, ?, 'nao', ?, 'nao', ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $nome);
  $query->bindValue(2, $tipo);
  $query->bindValue(3, $valor);
  $query->bindValue(4, $imagem);
  $query->bindValue(5, $time);
  try{
    $query->execute();
  } catch (PDOException $e) { 
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Comprável salvo com sucesso!' ]);
?>