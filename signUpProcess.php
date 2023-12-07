<?php

include_once 'db.php';

// Function to sanitize input data
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process signup form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user input
    $fullName = sanitizeInput($_POST['fullName']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? sanitizeInput($_POST['email']) : null;
    $rawPassword = isset($_POST['password']) ? $_POST['password'] : null;

    // Check if the email is valid
    if (!$email) {
        echo "Invalid email address.";
        exit();
    }

    // Check if the password is set
    if (!$rawPassword) {
        echo "Password is required.";
        exit();
    }

    // Hash and salt the password
    $password = password_hash($rawPassword . "akaSaltz", PASSWORD_DEFAULT);

    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sss", $fullName, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>