<?php
class AchievementHandler{
  private function __construct(){}

  public static function saveAchievement($dbInstance, $achieveId, $userId) {
    // VERIFICA SE É A PRIMEIRA TIMELINE DESTE USUÁRIO
    $sql = "SELECT * FROM usuarios_conquistas WHERE usuario = ? AND conquista = {$achieveId}";
    $query = $dbInstance->prepare($sql);
    $query->bindValue(1, $userId, PDO::PARAM_INT);
    try{
      $query->execute();
    } catch (PDOException $e) {
      return print(json_encode([ 'error' => $e->errorInfo ]));
    }

    // ADICIONA OS COINS NA CONTA DO USUARIO E REGISTRA A CONQUISTA
    if (empty($query->fetch())) {
      $sql = "INSERT INTO usuarios_conquistas(usuario, conquista) VALUES(?, {$achieveId})";
      $query = $dbInstance->prepare($sql);
      $query->bindValue(1, $userId, PDO::PARAM_INT);
      $query->execute();

      $sql = "SELECT premio_coins FROM conquistas WHERE id = {$achieveId}";
      $query = $dbInstance->prepare($sql);
      $query->execute();
      $coins = intval($query->fetch(PDO::FETCH_ASSOC)['premio_coins']);

      $sql = "UPDATE usuarios SET coins = ? WHERE id = ?";
      $query = $dbInstance->prepare($sql);
      $query->bindValue(1, $coins, PDO::PARAM_INT);
      $query->bindValue(2, $userId, PDO::PARAM_INT);
      $query->execute();

      return $coins;
    } else {
      return false;
    }
  }
}
?>