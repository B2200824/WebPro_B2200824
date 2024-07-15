<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email exists in the users table
    $conn = new mysqli("localhost", "root", "", "cinema");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));

        // Store the token in the password_resets table
        $sql = "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')";
        if ($conn->query($sql) === TRUE) {
            // Send email with the reset link
            $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
            $subject = "Password Reset";
            $message = "Click on this link to reset your password: $resetLink";
            $headers = "From: no-reply@yourwebsite.com";

            mail($email, $subject, $message, $headers);

            echo "An email with the reset link has been sent to your email address.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No account found with that email address.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <header>
        <h1>Forgot Password</h1>
    </header>
    <div class="container">
        <form method="POST" action="forgot_password.php">
            <div class="form-group">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
