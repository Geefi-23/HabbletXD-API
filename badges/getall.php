<?php
  require '../utils/Headers.php';

  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;

  $db = DataBase::getInstance();

  $sql = "SELECT * FROM compraveis WHERE tipo = 'emblema' AND data + 60 * 60 * 24 * 3 > ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, time(), PDO::PARAM_INT);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro1' ]));
  }
  $newbadges = $query->fetchAll(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM compraveis WHERE tipo = 'emblema' AND gratis = 'sim'";
  $query = $db->prepare($sql);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => 'Erro2' ]));
  }
  $freebadges = $query->fetchAll(PDO::FETCH_ASSOC);

  $sql = "SELECT * FROM compraveis WHERE tipo = 'emblema' AND gratis = 'nao' AND data + 60 * 60 * 24 * 3 < ?";
  $query = $db->prepare($sql);
  $query->bindValue(1, time(), PDO::PARAM_INT);
  try{
    $query->execute();
  } catch (PDOException $e) {
    return print(json_encode([ 'error' => $e->errorInfo ]));
  }
  $badges = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([ 'free' => $freebadges, 'new' => $newbadges, 'normal' => $badges ]);
?>