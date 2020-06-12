<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);
require_once 'config.php';
$host           = $config['database']['host'];
$db_name        = $config['database']['db_name'];
$db_username    = $config['database']['db_username'];
$db_password    = $config['database']['db_password'];
$dsn            = 'mysql:host=' . $host . ';dbname=' . $db_name;
$options        = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    exit($e->getMessage());
}
