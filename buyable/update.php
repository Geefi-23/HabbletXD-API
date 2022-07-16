<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }

  if (!$user->hasPermission(8)) {
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar essa ação.' ]));
  }

  $data = json_decode(file_get_contents('php://input'));
  $db = DataBase::getInstance();

  $id = $data->id;
  $nome = $data->nome;
  $valor = $data->valor;
  $tipo = $data->tipo;
  $gratis = $data->gratis;
  $sql = "UPDATE compraveis SET nome = ?, valor = ?, tipo = ?, gratis = ? WHERE id = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $nome);
  $query->bindValue(2, $valor);
  $query->bindValue(3, $tipo);
  $query->bindValue(4, $gratis);
  $query->bindValue(5, $id, PDO::PARAM_INT);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'Comprável atualizado com sucesso.' ])
?>