<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $url = $_GET['key'];
  $sql = "SELECT n.id, n.titulo, n.resumo, c.nome AS `categoria`, c.icone AS `categoria_icone`, n.imagem, 
      n.criador, n.data, n.url, n.visualizacao, n.texto
      FROM noticias AS n
      INNER JOIN noticias_cat AS c
      ON c.id = n.categoria
      WHERE n.url = ? AND n.status = 'ativo'" ;
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