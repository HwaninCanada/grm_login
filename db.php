<?php

// Load environment variables

try{

    require_once '/home/bitnami/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

}catch(Exception $e)
{
    $s = $e->getMessage() . ' (Error Code:' . $e->getCode() . ')';
}

// Get database credentials from environment variables
$db_host = $_ENV['DB_HOST'];
$db_database = $_ENV['DB_DATABASE'];
$db_username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];

// Establish a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_database);

// Check the connection
if ($conn->connect_error) {
    die("Can't Connect with the DB: " . $conn->connect_error);
}
?>