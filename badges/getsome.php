<?php
  require '../utils/Headers.php';

  $badges = json_decode(file_get_contents('https://safehabbo.online/api/api.php'));
  if (!$badges) 
    return print(json_encode([ 'error' => 'Não foi possível carregar os emblemas' ]));

  echo json_encode($badges->data);
?>