<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo 'All fields are required.';
        exit();
    }

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            echo 'Login successful.';
        } else {
            echo 'Incorrect password.';
        }
    } else {
        echo 'No account found with that email.';
    }

    $stmt->close();
    $conn->close();
}
?>
