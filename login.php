<?php
// Database connection
$servername = "localhost";
$db_username = "root";         // Replace with your database username
$db_password = "";             // Replace with your database password
$dbname = "alumni_db";         // Database name for the Alumni Tracking System

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $username = $conn->real_escape_string($_POST['username']); // Email
    $password = $_POST['password'];

    // Query to check the user
    $sql = "SELECT * FROM alumni WHERE email='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            echo "<p>Login successful! Welcome, " . htmlspecialchars($row['full_name']) . ".</p>";
            header("Location: ./index.html");
exit;  

        } else {
            echo "<p>Invalid password. Please try again.</p>";
        }
    } else {
        echo "<p>User not found. Please register first.</p>";
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Alumni Tracking System</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Alumni Tracking System</h2>
        <form id="login-form" method="POST" action="login.php">
            <label for="username">Username (Email):</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        
        <p><a href="#">Forgot your password?</a>   <a href="./register.html">Register here</a></p>
    </div>
</body>
</html>
