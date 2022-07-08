<?php
namespace Utils;

require __DIR__ . '/../vendor/autoload.php';

class DataBase{
  // CONFIGURAÇÃO DO SEU BANCO DE DADOS
  private static $username = 'geefi';
  private static $password = 'd4b4nkka';
  private static $hostname = 'localhost';
  private static $port     = '3306';
  private static $dbname   = 'habbletxd';

  private function __construct(){}
  
  public static function getInstance() {
    $db = new \PDO("mysql:host=".self::$hostname.":".self::$port.";dbname=".self::$dbname, self::$username, self::$password);
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $db;
  }
}
?>
