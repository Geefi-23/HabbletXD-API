<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\Authenticate;

  $db = DataBase::getInstance();

  $url = $_GET['key'];

  $liked;
  if ($user = Authenticate::authenticate()) { // se estiver autenticado, vai checar se já deu like nesse post
    $sql = "SELECT id FROM noticias_likes WHERE noticia_url = ? AND usuario_id = ?";
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

  $sql = "SELECT n.id, n.titulo, n.resumo, c.nome AS `categoria`, c.icone AS `categoria_icone`, n.imagem, 
      n.criador, n.data, n.url, n.visualizacao, n.texto, COUNT(nl.id) AS `likes`, $liked AS `liked`
      FROM noticias AS n
      INNER JOIN noticias_cat AS c
      ON c.id = n.categoria
      LEFT JOIN noticias_likes AS nl
      ON n.url = nl.noticia_url
      WHERE n.url = ? AND n.status = 'ativo'
      GROUP BY n.id";
  $query = $db->prepare($sql);
  $query->bindValue(1, $url);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $news = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM noticias_comentarios WHERE id_noticia = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $news['id']);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $comments = $query->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode([ 'success' => 'Notícia encontrada com sucesso!', 'object' => $news, 'comentarios' => $comments ]); 
?>