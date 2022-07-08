<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  $db = DataBase::getInstance();

  $url = $_GET['key'];

  $liked;
  if ($user = Authenticate::authenticate()) { // se estiver autenticado, vai checar se já deu like nesse post
    $sql = "SELECT id FROM pixel_likes WHERE pixel_url = ? AND usuario_id = ?";
    $query = $db->prepare($sql);
    $query->bindValue(1, $url);
    $query->bindValue(2, intval($user['id']), PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
      $liked = 0;
    } else {
      $liked = 1;
    }
  } else {
    $liked = 0;
  }

  $sql = "SELECT p.id, p.titulo, p.descricao as `resumo`, p.url,
      p.autor as `criador`, p.data, p.imagem, c.nome AS `categoria`, COUNT(pl.id) AS `likes`, $liked AS `liked`
      FROM pixel AS p
      INNER JOIN pixel_cat AS c
      ON c.id = p.categoria
      LEFT JOIN pixel_likes AS pl
      ON p.url = pl.pixel_url
      WHERE p.url = ? AND p.status = 'sim'
      GROUP BY p.id";
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $art = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM pixel_comentarios WHERE id_pixel = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $art['id']);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $comments = $query->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode([ 'success' => 'Arte encontrada com sucesso!', 'object' => $art, 'comentarios' => $comments ]); 
?>