<?php
  require '../utils/Headers.php';

  require '../utils/MediaHandler.php';
  require '../utils/PanelToken.php';

  $dir = '../../images/';
  if (!isset($_COOKIE['hp_pages_auth']) || !PanelToken::isValid($_COOKIE['hp_pages_auth'])){
    return print(json_encode([ 'error' => 'Você não está autenticado!' ]));
  }
?>