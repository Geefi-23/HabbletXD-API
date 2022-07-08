<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\HPDataBase;

  $limit = $_GET['limit'];

  $db = HPDataBase::getInstance();
  $sql = "SELECT hm.id, hm.usuario, DATE_FORMAT(h.comeca, '%H:%i') AS `comeca`, DATE_FORMAT(h.termina, '%H:%i') AS `termina` 
  FROM hp_radio_horarios_marcados AS hm
  INNER JOIN hp_radio_horarios AS h
  ON hm.horario = h.id AND h.comeca > CURTIME()
  WHERE hm.usuario != ''
  LIMIT $limit";

  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($results);
?>