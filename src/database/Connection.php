<?php

namespace AllanRezende\AppMercado\Database;

use Dotenv\Dotenv;
use PDO;
use Exception;

class Connection {
    private PDO $pdo;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../config")->load();
        $this->pdo = new PDO(
            "pgsql:host=" . $_ENV["DB_HOST"] . ";port=" . $_ENV["DB_PORT"] . ";dbname=" . $_ENV["DB_NAME"],
            $_ENV["DB_USER"],
            $_ENV["DB_PASS"],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
    }

    public function query(string $sql, array $params = []) {
        if (empty($sql)) throw new Exception("O parametro informando o sql é obrigatório.");
        
        $stmt = $this->pdo->prepare($sql);
        if ($params) {
            foreach ($params as $key => $value) {
                $param = (substr($key, 0, 1) == ":") ? $key : ":" . $key;
                $stmt->bindValue(($param), $value);
            }
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function beginTransaciton() {
        return self::$pdo->beginTransaction();
    }

    public static function commit() {
        return self::$pdo->commit();
    }

    public static function rollBack() {
        if (self::$pdo->inTransaction()) {
            return self::$pdo->rollBack();
        }
    }
}