<?php
// Database connection
$servername = "localhost";
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "alumni_db";      // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store form data and error message
$email = $password_input = "";
$email_err = $password_err = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required.";
    } else {
        $email = $_POST["email"];
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Password is required.";
    } else {
        $password_input = $_POST["password"];
    }

    // If no errors, check if the user exists in the database
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, password, designation FROM teachers WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // User found
            $row = $result->fetch_assoc();
            $hashed_password = $row["password"];

            // Verify password
            if (password_verify($password_input, $hashed_password)) {
                // Password is correct, set session and redirect
                session_start();
                $_SESSION["teacher_id"] = $row["id"];
                $_SESSION["teacher_designation"] = $row["designation"];
                header("Location: ./index.html"); // Redirect to a teacher dashboard or another page
                exit();
            } else {
                $password_err = "Invalid password.";
            }
        } else {
            $email_err = "No account found with this email.";
        }
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
    <title>Teacher Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 90px;
            padding: 50px;
            background-color: #dbd5e1; /* Single background color */
            background: url('https://t3.ftcdn.net/jpg/04/17/77/78/360_F_417777825_v7o8RvkQhxpZkE0ZBD4xwzri5hGFHkO3.jpg') no-repeat center center/cover;
            color: #333;
        }

        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #6a11cb;
        }

        .login-container label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .login-container input:focus {
            border-color: #fc25f8;
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background: #6a11cb;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-container button:hover {
            background: #fc25f8;
        }

        .login-container p {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
            color: #666;
        }

        .login-container p a {
            color: #6a11cb;
            text-decoration: none;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Teacher Login</h1>
        <form action="http://localhost/tpo_login.php" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $email_err; ?></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <span class="error"><?php echo $password_err; ?></span>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="./tpo_register.html" style="color: #6a11cb;">Register here</a>.</p>
    </div>

</body>
</html>
