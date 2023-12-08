<?php

include_once 'db.php';

function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email = filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) ? sanitizeInput($_REQUEST['email']) : null;
    $rawPassword = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

    if (!$email || !$rawPassword) {
        // Handle invalid input
        echo "<script>alert('Invalid input. Please provide a valid email and password.'); window.location.href = 'index.html';</script>";
        exit();
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($rawPassword . "akaSaltz", $hashedPassword)) {
            // Password is correct, perform login actions
            echo "<script>alert('Login successful!');</script>";
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href = 'index.html';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found. Please check your email.'); window.location.href = 'index.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>