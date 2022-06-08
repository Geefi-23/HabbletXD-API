<?php
  class Token{
    private const secretkey = 'ZWxtNGNoMDRBTEY0';

    private function __construct(){}

    public static function create($userId) {
      $header = [
        "alg" => "HS256",
        "typ" => "JWT"
      ];
      $header = base64_encode(json_encode($header));

      $payload = [
        "iss" => "localhost",
        "sub" => $userId
      ];
      $payload = base64_encode(json_encode($payload));

      $signature = hash_hmac('sha256', $header.$payload, self::secretkey);
      $token = "$header.$payload.$signature";
      return $token;
    }
    public static function decode($token) {
      $token = explode('.', $token);
      $token[0] = json_decode(base64_decode($token[0]));
      $token[1] = json_decode(base64_decode($token[1]));

      return $token;
    }
    public static function isValid($token) {
      $decoded = explode('.', $token);
      $header = $decoded[0];
      $payload = $decoded[1];
      $signature = $decoded[2];

      $valid = hash_hmac('sha256', $header.$payload, self::secretkey);
      return $signature == $valid;
    }
  }
?>