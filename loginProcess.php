<?php

$host = "localhost";
$dbname = "mysql";
$user = "root";
$pass = "V3q+NNfGutA@";

// Corrected syntax for retrieving user input from $_POST
$input_userID = $_POST["userID"];
$input_password = $_POST["password"];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo->query("SELECT * FROM users");
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Perform actions based on user input
    // For example, you can check if the user with the given ID and password exists in the result set

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Continue your logic based on the fetched results and user input here
// For example, you might want to check if the user with the provided ID and password exists in the $result array
?>