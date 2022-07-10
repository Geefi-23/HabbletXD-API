<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $likesql = "SELECT 
  u.usuario, 
  (COUNT(fl.id) + COUNT(pl.id) + COUNT(nl.id)) AS `likes`
  FROM usuarios AS u
  LEFT JOIN forum_likes AS fl ON fl.usuario_id = u.id
  LEFT JOIN pixel_likes AS pl ON pl.usuario_id = u.id
  LEFT JOIN noticias_likes AS nl ON nl.usuario_id = u.id
  GROUP BY u.id 
  ORDER BY likes DESC LIMIT 4";
  $likesqry = $db->prepare($likesql);
  $likesqry->execute();
  $likes = $likesqry->fetchAll(\PDO::FETCH_ASSOC);

  $comentariosql = "SELECT u.usuario, (COUNT(fc.id) + COUNT(pc.id) + COUNT(nc.id)) AS `comentarios`
  FROM usuarios AS u
  LEFT JOIN forum_comentarios AS fc ON BINARY fc.autor = u.usuario
  LEFT JOIN pixel_comentarios AS pc ON BINARY pc.autor = u.usuario
  LEFT JOIN noticias_comentarios AS nc ON BINARY nc.autor = u.usuario
  GROUP BY u.id 
  ORDER BY comentarios DESC LIMIT 4";
  $comentariosqry = $db->prepare($comentariosql);
  $comentariosqry->execute();
  $comentarios = $comentariosqry->fetchAll(\PDO::FETCH_ASSOC);

  $presencasql = "SELECT u.usuario, COUNT(pu.id) AS `presencas`
  FROM usuarios AS u
  LEFT JOIN presenca_usado AS pu ON BINARY pu.usuario = u.usuario
  GROUP BY u.id 
  ORDER BY presencas DESC LIMIT 4";
  $presencaqry = $db->prepare($presencasql);
  $presencaqry->execute();
  $presencas = $presencaqry->fetchAll(\PDO::FETCH_ASSOC);

  /*$presenca = "SELECT u.usuario, (COUNT(fc.id) + COUNT(pc.id) + COUNT(nc.id)) AS `comentarios`
  FROM usuarios AS u
  LEFT JOIN forum_comentarios AS fc ON BINARY fc.autor = u.usuario
  LEFT JOIN pixel_comentarios AS pc ON BINARY pc.autor = u.usuario
  LEFT JOIN noticias_comentarios AS nc ON BINARY nc.autor = u.usuario
  GROUP BY u.id 
  ORDER BY comentarios DESC LIMIT 5";*/
  
  echo json_encode([ 'comentarios' => $comentarios, 'likes' => $likes, 'presencas' => $presencas ]);
?>