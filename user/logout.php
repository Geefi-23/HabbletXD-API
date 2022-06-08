<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  $datetime = new DateTime();
  $datetime->setTimezone(new DateTimeZone('America/Sao_Paulo'));
  echo $datetime->format(DateTime::COOKIE);
  header('Set-Cookie: hxd-auth=deleted; path=/; expires='.$datetime->format(DateTime::COOKIE))
?>