<?php

namespace BarberAgenda\Config;

use BarberAgenda\Utils\Exceptions\DatabaseConnectionError;
use PDO;
use PDOException;

class Database {
  private static PDO $conn;

  public static function getConnection() {
    try {
      self::$conn = new PDO('pgsql:host=db;db_name=barberAgenda', "barberAgenda", "barberAgenda");
    } catch (PDOException $e) {
       throw new DatabaseConnectionError($e->getMessage());
    }

    return self::$conn;
  }
}

