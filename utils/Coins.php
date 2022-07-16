<?php
namespace Utils;

class Coins{
  private function __construct(){}

  public static function add($dbInstance, $userId, $coins) {
    $sql = "UPDATE usuarios SET coins = CAST(coins AS UNSIGNED) + ? WHERE id = ?";
    $query = $dbInstance->prepare($sql);
    $query->bindValue(1, $coins, \PDO::PARAM_INT);
    $query->bindValue(2, $userId, \PDO::PARAM_INT);
    $query->execute();

    return $coins;
  }
}
?>