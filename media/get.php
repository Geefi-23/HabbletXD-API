<?php
  require '../utils/Headers.php';

  require '../config/DataBase.php';
  require '../utils/MediaHandler.php';

  $db = DataBase::getInstance();

  $media = MediaHandler::get($_GET['filename']);

  header('Content-Type: image/'. $media['type']);
  header('Content-Length: '. $media['size']);
  
  fpassthru($media['ref']);
  exit;