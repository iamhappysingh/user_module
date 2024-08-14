<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="dashboard">
        <h2>Welcome to Your Dashboard</h2>
        <form id="updateProfileForm" method="post" action="update_profile.php">
            <button type="submit" class="btn">Update Profile</button>
        </form>
        <button class="btn" id="changePasswordButton">Change Password</button>
        <form id="logoutForm" method="post" action="logout.php">
            <button type="submit" class="btn">Logout</button>
        </form>
    </div>

    <script>
        document.getElementById('changePasswordButton').addEventListener('click', function() {
            // Open change password page in a new tab
            window.open('change_password.html', '_blank');
        });
    </script>
</body>

</html>
