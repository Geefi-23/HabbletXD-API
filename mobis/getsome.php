<?php
  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');

  $furni = json_decode(file_get_contents('https://api.habboapi.net/furni'));
  if (!$furni) 
    return print(json_encode([ 'error' => 'Não foi possível carregar os mobis' ]));

  $mobisKeys = array_rand($furni->data, 10);
  $mobis = [];
  foreach($mobisKeys as $key){
    array_push($mobis, $furni->data[$key]);
  }
  
  echo json_encode($mobis);
?>