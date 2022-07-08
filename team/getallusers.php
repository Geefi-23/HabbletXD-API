<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\HPDataBase;
  use Utils\DataBase;

  $db = HPDataBase::getInstance();
  $sql = "SELECT u.id, u.nome, u.facebook, u.twitter, u.discord, c.id AS cargo_id, c.nome AS cargo, '' AS avatar
        FROM hp_users AS u
        INNER JOIN hp_cargos AS c
        ON u.cargo = c.id";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);

  $db = DataBase::getInstance();
  foreach ($results as &$user) {
    $sql = "SELECT avatar FROM usuarios WHERE BINARY usuario = '".$user['nome']."'";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      $avatar = $result['avatar'];

      $user['avatar'] = $avatar;
    }
  }

  echo json_encode($results);
?>