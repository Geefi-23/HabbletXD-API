<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;
  use Utils\MediaHandler;

  if (!$user = HPAuthenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));
  }

  if (!$user->hasPermission(10)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar esta ação.' ]));
  }

  $db = DataBase::getInstance();

  $imagem = $_FILES['imagem'];
  $destino = $_POST['destino'];

  if (!$imagem = MediaHandler::save($imagem, 'carousel')) {
    return print(json_encode([ 'error' => 'Não foi possivel salvar a imagem.' ]));
  }
  
  $sql = "INSERT INTO index_carousel(imagem, destino) VALUES(?, ?)";
  $query = $db->prepare($sql);
  try {
    $query->execute([$imagem, $destino]);
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Imagem salva com sucesso.' ])
  
?>