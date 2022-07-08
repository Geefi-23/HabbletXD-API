<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\HPDataBase;
  use Utils\DataBase;

  if (!$user = Authenticate::authenticate()) {
    http_response_code(401);
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));
  }

  $data = json_decode(file_get_contents('php://input'));
  $db = DataBase::getInstance();
  $hpdb = HPDataBase::getInstance();

  $userid = $user['id'];
  $itemid = (int) $data->item->id;
  $itemnome = $data->item->nome;
  $itemvalor = (int) $data->item->valor;
  $codigo = '';
  $discord = $data->discord;
  $sql = "UPDATE usuarios SET coins = CAST(coins AS UNSIGNED) - $itemvalor WHERE id = $userid";
  $query = $db->prepare($sql);
  $query->execute();

  $sql = "INSERT INTO hp_compras(id_compravel, nome_compravel, codigo, discord_usuario)
          VALUES($itemid, '$itemnome', '$codigo', '$discord')";
  $query = $hpdb->prepare($sql);
  $query->execute();

  echo json_encode([ 'success' => 'Compra realizada com sucesso.' ])
?>