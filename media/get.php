<?php
  require '../config/DataBase.php';
  require '../utils/MediaHandler.php';

  $db = DataBase::getInstance();

  $media = MediaHandler::get($_GET['filename']);

  header('Access-Control-Allow-Headers: Content-Type, Set-Cookie');
  header('Access-Control-Allow-Origin: http://localhost:3000');
  header('Content-Type: image/'. $media['type']);
  header('Content-Length: '. $media['size']);
  
  fpassthru($media['ref']);
  exit;