<?php
require_once(__DIR__ . "/services/postgres-service.php");
require_once(__DIR__ . "/services/mariadb-service.php");
require_once(__DIR__ . "/class/ResponseBuilder.php");


$response = ResponseBuilder::make();
$err = false;
try {
    $mariadb_service = new MariadbService();
    $mariadb_name = $mariadb_service->getDatabaseName();
    $response
        ->status(200)
        ->append('Connected to MariaDB database: ' . $mariadb_name . '\n');
} catch (PDOException $e) {
    $err = true;
    $response
        ->status(503)
        ->append('Error connecting to MariaDB: ' . $e->getMessage())
        ->send();
}


try {
    $postgre_service = new PostgreService();
    $postgre_name = $postgre_service->getDatabaseName();
    $response
        ->status(200)
        ->append('Connected to PostgreSQL database: ' . $postgre_name . '\n');
} catch (PDOException $e) {
    $err = true;
    $response
        ->status(503)
        ->append('Error connecting to PostgreSQL: ' . $e->getMessage())
        ->send();
}

if (!$err) {
    $response->send();
}

