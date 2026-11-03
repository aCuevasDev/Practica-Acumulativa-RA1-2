<?php
require_once(__DIR__ . "/services/postgres-service.php");
require_once(__DIR__ . "/services/mariadb-service.php");

$postgre_service = new PostgreService();
$mariadb_service = new MariadbService();

$postgre_name = $postgre_service->getDatabaseName();
$mariadb_name = $mariadb_service->getDatabaseName();
