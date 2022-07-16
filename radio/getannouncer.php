<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\HPDataBase;

  $db = HPDataBase::getInstance();

  $sql = "SELECT hm.id, hm.usuario AS `nome`
          FROM hp_radio_horarios_marcados AS hm
          INNER JOIN hp_radio_horarios AS h
          ON h.id = hm.horario 
          WHERE hm.dia = CURDATE() AND h.comeca <= CURTIME() AND CURTIME() < h.termina
          LIMIT 1";
  $query = $db->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $sql = "DELETE FROM hp_radio_horarios_marcados";

  if ($result) {
    $resultid = (int) $result['id'];
    $sql .= " WHERE id < $resultid"; //deletando os horario que vieram antes do antes do locutor atual
    $query = $db->prepare($sql);
    $query->execute();

    return print(json_encode($result));
  }
  $query = $db->prepare($sql);
  $query->execute();

  echo '{}';
?>