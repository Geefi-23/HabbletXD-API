<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  
  $db = DataBase::getInstance();
  $sql = "SELECT v.id, v.nome, v.imagem, v.preco, v.valorltd, v.situacao, v.moeda, v.categoria AS `categoria_id`, 
        vc.nome AS `categoria`, v.icone, v.emblema
        FROM valores AS v
        INNER JOIN valores_cat AS vc
        ON v.categoria = vc.id
        ORDER BY v.id DESC";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($results);
?>