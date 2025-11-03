<?php
// Database connection
$servername = "localhost";
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "alumni_db";      // Database name for storing teacher info

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store form data and error messages
$faculty_name = $email = $password = $designation = "";
$faculty_name_err = $email_err = $password_err = $designation_err = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate faculty name
    if (empty($_POST["facultyName"])) {
        $faculty_name_err = "Faculty name is required.";
    } else {
        $faculty_name = $_POST["facultyName"];
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required.";
    } else {
        $email = $_POST["email"];
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Password is required.";
    } else {
        $password = $_POST["password"];
    }

    // Validate designation
    if (empty($_POST["designation"])) {
        $designation_err = "Designation is required.";
    } else {
        $designation = $_POST["designation"];
    }

    // If no errors, proceed with inserting data
    if (empty($faculty_name_err) && empty($email_err) && empty($password_err) && empty($designation_err)) {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Prepare SQL query to insert data into the database
        $sql = "INSERT INTO teachers (faculty_name, email, password, designation) 
                VALUES ('$faculty_name', '$email', '$hashed_password', '$designation')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 140px;
            background-color: #dbd5e1cc; /* Single background color */
            background: url('https://img.freepik.com/free-vector/minimalist-background-gradient-design-style_483537-3006.jpg') no-repeat center center/cover;
            color: #333;
        }

        .register-container {
            max-width: 450px;
            margin:  50px auto;
            margin-left:100pv;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
           
        }

        .register-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color:black;
        }

        .register-container label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #fc25f8;
        }

        .register-container input, .register-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #fc25f8;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .register-container input:focus, .register-container select:focus {
            border-color: #fc25f8;
            outline: none;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background: #fc25f8;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
           
        }

        .register-container button:hover {
            background: blue;
        }

        .register-container p {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
            color:#fc25f8;
        }

        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h1>Teacher Registration</h1>
        <form action="http://localhost/tpo_register.php" method="post">
            <label for="facultyName">Faculty Name</label>
            <input type="text" id="facultyName" name="facultyName" placeholder="Enter your name" value="<?php echo $faculty_name; ?>" required>
            <span class="error"><?php echo $faculty_name_err; ?></span>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $email_err; ?></span>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <span class="error"><?php echo $password_err; ?></span>

            <label for="designation">Designation</label>
            <select id="designation" name="designation" required>
                <option value="" disabled selected>Select your designation</option>
                <option value="Professor" <?php echo ($designation == 'Professor') ? 'selected' : ''; ?>>TPO Head</option>
                <option value="Assistant Professor" <?php echo ($designation == 'Assistant Professor') ? 'selected' : ''; ?>>TPO Coordinator</option>
                <option value="HOD" <?php echo ($designation == 'HOD') ? 'selected' : ''; ?>>Faculty</option>
                <option value="Other" <?php echo ($designation == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
            <span class="error"><?php echo $designation_err; ?></span>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="./login_tpo.html" style="color: #6a11cb; text-decoration: none;">Login here</a>.</p>
    </div>

</body>
</html>
