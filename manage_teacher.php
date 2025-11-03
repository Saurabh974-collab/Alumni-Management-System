<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alumni_db"; // Replace with your database name
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add teacher
if (isset($_POST['add_teacher'])) {
    $faculty_name = $_POST['faculty_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $designation = $_POST['designation'];

    $sql = "INSERT INTO teachers (faculty_name, email, password, designation) VALUES ('$faculty_name', '$email', '$password', '$designation')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher added successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle delete teacher
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM teachers WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher deleted successfully');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle edit teacher
if (isset($_POST['update_teacher'])) {
    $id = $_POST['id'];
    $faculty_name = $_POST['faculty_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $designation = $_POST['designation'];

    $sql = "UPDATE teachers SET faculty_name='$faculty_name', email='$email', password='$password', designation='$designation' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher updated successfully');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch teachers
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teacher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1, h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Manage Teacher</h1>

    <!-- Add Teacher Form -->
    <h2>Add New Teacher</h2>
    <form method="post">
        <label>Faculty Name:</label>
        <input type="text" name="faculty_name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <label>Designation:</label>
        <input type="text" name="designation" required>
        <input type="submit" name="add_teacher" value="Add Teacher">
    </form>

    <!-- Teacher Records Table -->
    <h2>Teacher Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Faculty Name</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['faculty_name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['designation'] . "</td>";
                    echo "<td>
                        <a href='?edit=" . $row['id'] . "'>Edit</a> | 
                        <a href='?delete=" . $row['id'] . "'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No teachers found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Edit Teacher Form -->
    <?php
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $edit_sql = "SELECT * FROM teacher WHERE id=$id";
        $edit_result = $conn->query($edit_sql);
        if ($edit_result->num_rows > 0) {
            $edit_row = $edit_result->fetch_assoc();
    ?>
        <h2>Edit Teacher</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
            <label>Faculty Name:</label>
            <input type="text" name="faculty_name" value="<?php echo $edit_row['faculty_name']; ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $edit_row['email']; ?>" required>
            <label>Password:</label>
            <input type="password" name="password" value="<?php echo $edit_row['password']; ?>" required>
            <label>Designation:</label>
            <input type="text" name="designation" value="<?php echo $edit_row['designation']; ?>" required>
            <input type="submit" name="update_teacher" value="Update Teacher">
        </form>
    <?php
        }
    }
    ?>
</body>
</html>
