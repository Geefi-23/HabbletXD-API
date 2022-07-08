<?php
  namespace Entities;

  use Utils\HPDataBase;
  use Utils\Permissions;

  class User extends Permissions {
    private $id;
    private $nome;
    private $cargo;
    private $permissions = [];
    private $ultimo_login;
    private $ultimo_ip;
    private $database;

    function __construct($userData) {
      $this->id = $userData['id'];
      $this->nome = $userData['nome'];
      $this->cargo = $userData['ultimo_login'];
      $this->ultimo_login = $userData['ultimo_ip'];
      $this->ultimo_ip = $userData['cargo'];
      $this->database = HPDataBase::getInstance();

      // getting permissions
      $sql = "SELECT permission AS `id` FROM hp_cargos_permissions WHERE cargo = ?";
      $query = $this->database->prepare($sql);
      $query->bindValue(1, $userData['cargo'], \PDO::PARAM_INT);
      $query->execute();

      $this->permissions = $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function hasPermission(int $permission) {
      foreach ($this->permissions as $p) {
        if (intval($p['id']) == $permission)
          return true;
      }
      return false;
    }

    public function getId() {
      return $this->id;
    }
    
    public function getNome() {
      return $this->nome;
    }

    public function getPermissions() {
      return $this->permissions;
    }

    public function getCargo() {
      return $this->cargo;
    }
    
  }
?>