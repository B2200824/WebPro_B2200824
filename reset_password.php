<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = new mysqli("localhost", "root", "", "cinema");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify the token
    $sql = "SELECT email FROM password_resets WHERE token='$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Update the user's password
        $sql = "UPDATE users SET password='$newPassword' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            // Delete the token
            $sql = "DELETE FROM password_resets WHERE token='$token'";
            $conn->query($sql);

            echo "Password has been reset successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid token.";
    }

    $conn->close();
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <header>
        <h1>Reset Password</h1>
    </header>
    <div class="container">
        <form method="POST" action="reset_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</body>
</html>
