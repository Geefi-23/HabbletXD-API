<?php
  function authenticate() {
    if (!isset($_COOKIE['__Host-habbletxd-auth']) || !Token::isValid($_COOKIE['__Host-habbletxd-auth'])){
      return false;
    }
    return true;
  }