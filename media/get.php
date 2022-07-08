<?php
  require '../utils/Headers.php';
  require __DIR__ . '/../vendor/autoload.php';

  use Utils\DataBase;
  use Utils\MediaHandler;

  $db = DataBase::getInstance();

  $allowedTypes = ['gif', 'png', 'jpg'];

  $filename = $_GET['filename'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  if (!in_array($ext, $allowedTypes)) {
    return print('vai hackear outro seu pau no cu');
  }

  $media = MediaHandler::get($_GET['filename']);

  header('Content-Type: image/'. $media['type']);
  header('Content-Length: '. $media['size']);
  
  fpassthru($media['ref']);
  exit;