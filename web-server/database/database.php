<?php

namespace Database;

require_once __DIR__ . "/../utils/loadenv.php";

use function Utils\loadenv;

loadenv();

class Database
{
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new \PDO("mysql:host=mysql;dbname=chato_reborn", getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));

            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS users (
                    id VARCHAR(36) PRIMARY KEY,
                    name VARCHAR(12) UNIQUE NOT NULL,
                    password_hash VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS messages (
                    id VARCHAR(36) PRIMARY KEY,
                    sender_id VARCHAR(36) NOT NULL,
                    content TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                    FOREIGN KEY (sender_id) REFERENCES users(id)
                );
            ");
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function prepare($sql): \PDOStatement
    {
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement");
        }

        return $stmt;
    }
}
