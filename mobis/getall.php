<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  $data = file_get_contents('https://images.habblet.city/gamedata/habbletnew_furni.json');
  if (!$data) 
    return print(json_encode([ 'error' => 'Não foi possível carregar os mobis' ]));
  
  echo $data;
?>