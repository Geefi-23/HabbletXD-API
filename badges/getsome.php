<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  $badges = json_decode(file_get_contents('https://safehabbo.online/api/api.php'));
  if (!$badges) 
    return print(json_encode([ 'error' => 'Não foi possível carregar os emblemas' ]));

  echo json_encode($badges->data);
?>