<?php
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;

  if (!$user = HPAuthenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));

  if (!$user->hasPermission(9))
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar esta ação.' ]));

  $data = json_decode(file_get_contents('php://input'));
  $db = DataBase::getInstance();

  $id = $data->id;
  $nome = $data->nome;
  $categoria = intval($data->categoria);
  $preco = $data->preco;
  $icone = $data->icone;
  $moeda = $data->moeda;
  $situacao = $data->situacao;
  $valorltd = $data->valorltd;
  $emblema = $data->emblema;

  $sql = "UPDATE valores SET nome = ?, categoria = ?, preco = ?, valorltd = ?, situacao = ?, icone = ?, 
          moeda = ?, emblema = ? 
          WHERE id = ?";
  $query = $db->prepare($sql);
  $query->execute([ $nome, $categoria, $preco, $valorltd, $situacao, $icone, $moeda, $emblema, $id ]);
  
  echo json_encode([ 'success' => 'Valor atualizado com sucesso' ]);
?>