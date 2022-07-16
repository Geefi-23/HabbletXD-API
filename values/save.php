<?php
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\HPAuthenticate;
  use Utils\MediaHandler;

  if (!$user = HPAuthenticate::authenticate())
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));

  if (!$user->hasPermission(9))
    return print(json_encode([ 'error' => 'Você não tem permissão para realizar esta ação.' ]));

  $data = json_decode($_POST['data']);

  if ($data->categoria !== '3' && !isset($_FILES['imagem']))
    return print(json_encode([ 'error' => 'Você não pode postar um valor sem uma imagem.' ]));

  if ($data->categoria === '3' && $data->urlimagem === '')
    return print(json_encode([ 'error' => 'Você não pode postar um valor sem uma imagem.' ]));

  $nome = $data->nome;
  $categoria = intval($data->categoria);
  $imagem;
  $preco = $data->preco;
  $urlimagem = $data->urlimagem;
  $icone = $data->icone;
  $moeda = $data->moeda;
  $situacao = $data->situacao;
  $valorltd = $data->valorltd;
  $emblema = '';

  if ($categoria === 3) {
    $imagem = $urlimagem;
    $emblema = $data->emblema;
  } else {
    if(!$imagem = MediaHandler::save($_FILES['imagem'], 'values')) {
      return print(json_encode([ 'error' => 'Não foi possível salvar o item.' ]));
    }
  }

  $db = DataBase::getInstance();
  $sql = "INSERT INTO valores(nome, categoria, imagem, preco, moeda, situacao, valorltd, icone, emblema) 
  VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $query = $db->prepare($sql);
  $query->bindValue(1, $nome);
  $query->bindValue(2, $categoria);
  $query->bindValue(3, $imagem);
  $query->bindValue(4, $preco);
  $query->bindValue(5, $moeda);
  $query->bindValue(6, $situacao);
  $query->bindValue(7, $valorltd);
  $query->bindValue(8, $icone);
  $query->bindValue(9, $emblema);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }

  echo json_encode([ 'success' => 'O item foi salvo com sucesso.' ])
?>