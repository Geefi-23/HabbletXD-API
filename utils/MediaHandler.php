<?php
  namespace Utils;

  class MediaHandler{
    private const MEDIADIR = __DIR__.'/../media/';
    private function __construct() {}

    public static function save($file, $dir) {
      $allowedTypes = ['gif', 'png', 'jpg'];
      $dire = self::MEDIADIR . $dir.'/';
      $ext = '.'.preg_replace("#\?.*#", "", pathinfo($file['name'], PATHINFO_EXTENSION));
      $filename = str_replace('=', '', base64_encode($file['name'].random_int(0, 9999)).$ext);

      if (!in_array($ext, $allowedTypes)) {
        return false;
      }
      
      $filedir = $dire.basename($filename);
      $filetmp = $file['tmp_name'];
    
      if (!move_uploaded_file($filetmp, $filedir)) 
        return false;

      return $dir.'/'.$filename;
    }

    public static function get($dir) {
      $path = self::MEDIADIR.$dir;
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $fp = fopen($path, 'rb');

      return [
        'type' => $type,
        'size' => filesize($path),
        'ref' => $fp
      ];
    }
  }
?>