<?php
session_start();
require_once 'db_connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = trim($_POST['current_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmNewPassword = trim($_POST['confirm_new_password']);

    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $response['error'] = 'All fields are required.';
    } elseif ($newPassword !== $confirmNewPassword) {
        $response['error'] = 'New passwords do not match.';
    } else {
        $userId = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($currentPassword, $hashedPassword)) {
            $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $newHashedPassword, $userId);

            if ($stmt->execute()) {
                $response['success'] = 'Password changed successfully.';
            } else {
                $response['error'] = 'An error occurred while updating the password.';
            }

            $stmt->close();
        } else {
            $response['error'] = 'Current password is incorrect.';
        }
    }

    $conn->close();
}

echo json_encode($response);
?>
