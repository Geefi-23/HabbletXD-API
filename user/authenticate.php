<?php
  require '../utils/Headers.php';

  require '../utils/Token.php';

  if (!isset($_COOKIE['hxd-auth']) || !Token::isValid($_COOKIE['hxd-auth'])) {
    return print(json_encode([ 'authenticated' => false ]));
  }
  return print(json_encode([ 'authenticated' => true ]));
?>