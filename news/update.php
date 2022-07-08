<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate()){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }
  
  if (!$user->hasPermission(1)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar essa ação.' ]));
  }

  $data = json_decode(file_get_contents('php://input'));

  $db = DataBase::getInstance();

  $titulo = $data->titulo;
  $resumo = $data->resumo;
  $texto = $data->texto;
  $status = $data->status;
  $url = $data->url;

  $sql = 'UPDATE noticias SET titulo = ?, resumo = ?, texto = ?, status = ? WHERE url = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $titulo);
  $query->bindValue(2, $resumo);
  $query->bindValue(3, $texto);
  $query->bindValue(4, $status);
  $query->bindValue(5, $url);
  try {
    $query->execute();
  } catch (PDOException $e) {
    print(json_encode([ 'error' => 'Não foi possível atualizar esta notícia', 'details' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Noticia atualizada com sucesso' ]);
?>