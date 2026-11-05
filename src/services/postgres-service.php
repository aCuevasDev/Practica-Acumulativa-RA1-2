<?php
require_once __DIR__ . "/connection-interface.php";
class PostgreService implements Connection_interface {
    private PDO $db;

    public function __construct() {
        $dsn = 'pgsql:host=postgres;port=5432;dbname=' . getenv('POSTGRES_NAME');
        $this->db = new PDO($dsn, getenv('POSTGRES_USER'), getenv('POSTGRES_PASSWORD'));
    }

    public function getConnection(): PDO {
        return $this->db;
    }

    public function getDatabaseName(): string {
        return $this->db->query('SELECT current_database()')->fetchColumn();
    }

    // public function query(string $query, array $params = []): PDOStatement {
    //     $stmt = $this->db->prepare($query);
    //     $stmt->execute($params);
    //     return $stmt;
    // }
}

