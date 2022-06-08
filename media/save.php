<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost');
  header('Access-Control-Allow-Credentials: true');

  require '../utils/MediaHandler.php';
  require '../utils/PanelToken.php';

  $dir = '../../images/';
  if (!isset($_COOKIE['hp_pages_auth']) || !PanelToken::isValid($_COOKIE['hp_pages_auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }
?>