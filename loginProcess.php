<?php

include_once 'db.php';

function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? sanitizeInput($_POST['email']) : null;
    $rawPassword = isset($_POST['password']) ? $_POST['password'] : null;

    if (!$email || !$rawPassword) {
        // Handle invalid input
        echo "<script>alert('Invalid input. Please provide a valid email and password.'); window.location.href = 'login.html';</script>";
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
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href = 'login.html';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found. Please check your email.'); window.location.href = 'login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>