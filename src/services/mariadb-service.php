<?php
require_once __DIR__ . "/connection-interface.php";
class MariadbService implements Connection_interface {
    private PDO $db;

    public function __construct() {
        $dsn = 'mysql:host=mariadb;port=3306;dbname=' . getenv('MARIADB_NAME');
        $this->db = new PDO($dsn, getenv('MARIADB_USER'), getenv('MARIADB_PASSWORD'));
    }

    public function getConnection(): PDO {
        return $this->db;
    }

    public function getDatabaseName(): string {
        return $this->db->query('SELECT DATABASE()')->fetchColumn();
    }
}