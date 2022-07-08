<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\HPDataBase;

  $db = HPDataBase::getInstance();

  $sql = "SELECT hm.id, hm.usuario AS `nome`
          FROM hp_radio_horarios_marcados AS hm
          INNER JOIN hp_radio_horarios AS h
          ON h.id = hm.horario AND h.comeca <= CURTIME() AND CURTIME() < h.termina
          WHERE hm.dia = CURDATE()
          LIMIT 1";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $resultid = (int) $result['id'];
    $scheduleDeleteId = $resultid - 1;
    $sql = "DELETE FROM hp_radio_horarios_marcados WHERE id = $scheduleDeleteId"; //deletando o horario que veio antes do locutor atual
    $query = $db->prepare($sql);
    $query->execute();
    echo json_encode($result);
  }
  else
    echo '{}';
?>