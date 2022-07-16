<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $type = '%%';
  $user = '%%';

  if (isset($_GET['type'])) 
    $type = $_GET['type'];
  
  if (isset($_GET['user']))
    $user = $_GET['user'];

  $sql = "SELECT uc.*, c.nome AS `item_nome`, c.imagem AS `item_imagem`
  FROM usuarios_comprados AS uc
  INNER JOIN compraveis AS c
  ON uc.item = c.id
  WHERE c.tipo = ? AND BINARY uc.usuario = ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, $type);
  $query->bindValue(2, $user);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($results);
?>