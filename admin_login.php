<?php
// Initialize variables for username, password, and error message
$username = '';
$password = '';
$error = '';

// Database connection settings
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "alumni_db"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $error = 'Both fields are required!';
    } else {
        // Query to check if username exists in the database
        $sql = "SELECT * FROM admin_users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // If username exists in the database
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify password (assuming password is hashed in the database)
            if (password_verify($password, $row['password'])) {
                // Password is correct, start a session and redirect to dashboard
                session_start();
                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                header("Location: dashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                $error = 'Invalid password!';
            }
        } else {
            $error = 'No user found with that username!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Global styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: violet;
            color: white;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style-type: none;
        }

        .sidebar ul li {
            margin-bottom: 20px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: grey;
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }

        header {
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 28px;
            color: #333;
        }

        .content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #666;
        }

        /* Login form styles */
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: violet;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #ed9f51;
            transform: translateY(-2px);
        }

        input[type="submit"]:active {
            background-color: #ff7dee;
            transform: translateY(1px);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="index.html">Home Page</a></li>
                <li><a href="manage_admin.php">Manage Alumni</a></li>
                <li><a href="http://localhost/manage_teacher.php">Manage Teacher</a></li>
                
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Welcome to the Admin Dashboard</h1>
            </header>
            <div class="content">
                <h2>Admin Login</h2>
                <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                <form action="admin_login.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                    <br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    <br>
                    <input type="submit" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
