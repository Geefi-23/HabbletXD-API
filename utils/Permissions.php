<?php
  namespace Utils;
  abstract class Permissions{
    protected function __construct(){}

    private $permissions;

    abstract protected function hasPermission(int $permission);
  }
?>