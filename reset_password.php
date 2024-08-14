<?php
session_start();
require 'db_connect.php'; // Include your database connection file

if (!isset($_GET['email']) || !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
    exit();
}

$email = $_GET['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new passwords
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        echo "Password must be at least 6 characters long.";
    } else {
        // Update password in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Your password has been updated successfully.";
        } else {
            echo "Failed to update password. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form">
            <form id="reset-password-form" method="post" class="form__container">
                <h2 class="form__title">Reset Password</h2>
                <input type="password" name="password" placeholder="New Password" class="input" required />
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="input" required />
                <button type="submit" class="btn">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
