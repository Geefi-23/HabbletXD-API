<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  require '../config/DataBase.php';

  $db = DataBase::getInstance();

  $url = $_GET['key'];
  $sql = "SELECT p.id, p.titulo, p.descricao as `resumo`,
      p.autor as `criador`, p.data, p.imagem, c.nome AS `categoria` 
      FROM pixel AS p
      INNER JOIN pixel_cat AS c
      ON c.id = p.categoria
      WHERE p.url = ? AND p.status = 'sim'";
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