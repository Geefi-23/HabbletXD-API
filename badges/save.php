<?php
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));
  
  if (!$user->hasPermission(12)) 
    return print(json_encode([ 'error' => 'Você não tem autorização para realizar esta ação.' ]));
  
  $data = json_decode(file_get_contents('php://input'));
  $db = DataBase::getInstance();

  $nome = $data->nome;
  $imagem = $data->imagem;
  $tutorial = $data->tutorial;
  $gratis = $data->gratis;
  $conquistado = $data->conquistado;
  $codigo = $data->codigo;
  $usuarios_qtd = $data->usuarios_qtd;

  $sql = "INSERT INTO emblemas(nome, imagem, tutorial, gratis, conquistado, codigo, usuarios_qtd) 
  VALUES(?, ?, ?, ?, ?, ?, ?)";
  $query = $db->prepare($sql);
  try {
  $query->execute([ $nome, $imagem, $tutorial, $gratis, $conquistado, $codigo, $usuarios_qtd ]);
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  
  echo json_encode([ 'success' => 'Emblema salvo com sucesso.' ]);
?>