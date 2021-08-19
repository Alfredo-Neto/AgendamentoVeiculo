<?php

namespace AgVeiculo\Database;

use PDO;

class DbConnectionFactory {
    private static $host = 'localhost';
    private static $user = 'postgres';
    private static $password = '123456';
    private static $name = 'agendamento_veiculo';
    private static $port = '5432';

    public static function get()
    {
        $pdo = new PDO(
            'pgsql:host='
            . self::$host
            . ';port=' . self::$port . '.dbname=' . self::$name . ';user='
            . self::$user . ';password=' . self::$password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
    }
}