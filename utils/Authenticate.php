<?php
namespace Utils;

require __DIR__ . '/../vendor/autoload.php';

use Utils\Token;
use Utils\DataBase;

class Authenticate {
  public static function authenticate() {
    if ((isset($_COOKIE['__Host-habbletxd_auth']) && Token::isValid($_COOKIE['__Host-habbletxd_auth']))){
      $db = DataBase::getInstance();

      $id = Token::decode($_COOKIE['__Host-habbletxd_auth'])[1]->sub;
      $sql = "SELECT id, usuario, assinatura, missao, twitter, presenca, avatar, coins AS `xdcoins` FROM usuarios WHERE id = $id";
      $query = $db->prepare($sql);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      if (!$result) 
        return false;
      return $result;
    }
    return false;
  }
}

?>