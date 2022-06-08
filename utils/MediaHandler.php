<?php
  class MediaHandler{
    private const MEDIADIR = '../media/';
    private function __construct() {}

    public static function save($file, $dir) {
      $dire = self::MEDIADIR . $dir.'/';
      $ext = '.'.preg_replace("#\?.*#", "", pathinfo($file['name'], PATHINFO_EXTENSION));
      $filename = str_replace('=', '', base64_encode($file['name'].'ekwd1"s').$ext);
      
      $filedir = './'.$dire.basename($filename);
      $filetmp = $file['tmp_name'];
    
      if (move_uploaded_file($filetmp, $filedir)) {
        //echo json_encode([ 'success' => 'Arquivo salvo com sucesso!' ]);
      } else {
        //echo json_encode([ 'error' => 'Não foi possível salvar o arquivo' ]);
      }

      return $dir.'/'.$filename;
    }

    public static function get($dir) {
      $path = './'.$dir;
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