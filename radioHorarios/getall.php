<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\Authenticate;
  use Utils\HPDataBase;

  $db = HPDataBase::getInstance();

  $sql = "SELECT hm.id, CASE WHEN hm.usuario IS NULL THEN 'DjXD' ELSE hm.usuario END AS usuario, 

          DATE_FORMAT(h.comeca, '%H:%i') AS `comeca`, DATE_FORMAT(h.termina, '%H:%i') AS `termina` 
          FROM hp_radio_horarios AS h
          LEFT JOIN hp_radio_horarios_marcados AS hm
          ON hm.horario = h.id
          WHERE h.comeca >= CURTIME() AND hmdia = CURDATE()";
  $query = $db->prepare($sql);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($results);
?>