<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        echo 'All fields are required.';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email format.';
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $passwordHash);

    if ($stmt->execute()) {
        // Start user session and redirect to dashboard
        $_SESSION['user_id'] = $stmt->insert_id; // Get the ID of the newly created user
        echo 'Registration successful. Redirecting to dashboard...';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
