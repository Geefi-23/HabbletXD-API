<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;
  use Utils\MediaHandler;

  if (!$user = Authenticate::authenticate()) {
    return print(json_encode([ 'error' => 'Você não está autenticado.' ]));
  }

  $data = json_decode($_POST['data']);

  $db = DataBase::getInstance();

  $usuario = $user['usuario'];
  $senha = md5($data->senha);
  $novasenha = $data->novasenha === '' ? $data->novasenha : md5($data->novasenha);
  $missao = $data->missao;
  $twitter = $data->twitter;
  $assinatura = $data->assinatura;

  $sql = 'SELECT * FROM usuarios WHERE usuario = ? AND senha = ?';
  $query = $db->prepare($sql);
  $query->bindValue(1, $usuario);
  $query->bindValue(2, $senha);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível atualizar as informações do usuario', 'details' => $e->errorInfo ]));
  }

  $result = $query->fetch(PDO::FETCH_ASSOC);
  if (empty($result)) {
    return print(json_encode([ 'error' => 'Este usuário não existe' ]));
  }

  if ($fundo_perfil = isset($_FILES['fundo_perfil'])) {
    $fundo_perfil = $_FILES['fundo_perfil'];
    $fundo_perfil = MediaHandler::save($fundo_perfil, 'avatars');
  }

  $novasenha = $novasenha != $result['senha'] && $novasenha != '' ? $novasenha : $result['senha'];
  $missao = $missao != $result['missao'] && $missao != '' ? $missao : $result['missao'];
  $assinatura = $assinatura != $result['assinatura'] && $assinatura != '' ? $assinatura : $result['assinatura'];
  $twitter = $twitter != $result['twitter'] && $twitter != '' ? $twitter : $result['twitter'];
  $sql = "UPDATE usuarios SET senha = ?, missao = ?, assinatura = ?, twitter = ?, avatar = ? WHERE id = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $novasenha);
  $query->bindValue(2, $missao);
  $query->bindValue(3, $assinatura);
  $query->bindValue(4, $twitter);
  $query->bindValue(5, $fundo_perfil ? $fundo_perfil : '');
  $query->bindValue(6, $result['id']);
  try {
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Não foi possível atualizar as informações do usuario', 'details' => $e->errorInfo, 'query' => $sql ]));
  }

  

  echo json_encode([ 'success' => 'Informações atualizadas com sucesso!' ]);
?>