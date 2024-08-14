<?php
session_start();
require 'db_connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Redirect to reset password page with the email as a query parameter
            header('Location: reset_password.php?email=' . urlencode($email));
            exit();
        } else {
            echo "No account found with that email address.";
        }

        $stmt->close();
    } else {
        echo "Invalid email format.";
    }
}
?>
