<?php
  require '../utils/Headers.php';

  $datetime = new DateTime();
  $datetime->setTimezone(new DateTimeZone('America/Sao_Paulo'));
  echo $datetime->format(DateTime::COOKIE);
  header('Set-Cookie: hxd-auth=deleted; path=/; expires='.$datetime->format(DateTime::COOKIE))
?>