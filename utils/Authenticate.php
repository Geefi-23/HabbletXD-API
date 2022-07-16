<?php
namespace Utils;

require __DIR__ . '/../vendor/autoload.php';

use Utils\Token;
use Utils\DataBase;
use Utils\HPDataBase;
use Utils\Coins;

class Authenticate {
  public static function authenticate() {
    if ((isset($_COOKIE['__Host-habbletxd_auth']) && Token::isValid($_COOKIE['__Host-habbletxd_auth']))){
      $db = DataBase::getInstance();

      $id = Token::decode($_COOKIE['__Host-habbletxd_auth'])[1]->sub;
      $sql = "SELECT id, usuario, assinatura, missao, twitter, presenca, avatar, coins AS `xdcoins`, ultimo_dia,
      artigo_delay
      FROM usuarios WHERE id = $id";
      $query = $db->prepare($sql);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      if (!$result) 
        return false;
      
      $hpdb = HPDataBase::getInstance();
      $sql = "SELECT c.nome AS `cargo` FROM hp_cargos AS c
        INNER JOIN hp_users AS u
        ON u.cargo = c.id AND BINARY u.nome = ?";
      $query = $hpdb->prepare($sql);
      $query->bindValue(1, $result['usuario']);
      try {
        $query->execute();
      } catch (\PDOException $e) {
        return print(json_encode([ 'error' => $e->errorInfo ]));
      }
      $cargo = $query->fetch(\PDO::FETCH_ASSOC);

      if ($cargo) {
        $result['cargo'] = $cargo['cargo'];
      } else {
        $result['cargo'] = 'Não é membro';
      }

      // award by login a day
      $yesterday = time() - 60 * 60 * 24;
      if ((int) $result['ultimo_dia'] <= $yesterday) {
        Coins::add($db, $id, 5);
        $result['coins'] = ((int) $result['coins']) + 5;
        $sql = "UPDATE usuarios SET ultimo_dia = ? WHERE id = ?";
        $query = $db->prepare($sql);
        $query->bindValue(1, time());
        $query->bindValue(2, $id);
        $query->execute();
      }

      return $result;
    }
    return false;
  }
}

?>