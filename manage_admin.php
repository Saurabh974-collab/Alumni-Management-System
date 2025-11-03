<?php
// Assuming you have a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alumni_db";  // Change to your actual DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add alumni information when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Collect data from the form
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $college = $_POST['college'];
    $degree = $_POST['degree'];
    $field_of_study = $_POST['field_of_study'];
    $graduation_year = $_POST['graduation_year'];
    $employer = $_POST['employer'];
    $job_title = $_POST['job_title'];
    $linkedin = $_POST['linkedin'];
    $consent = isset($_POST['consent']) ? 1 : 0; // If consent checkbox is checked, set consent to 1

    // Insert query to add new alumni
    $sql = "INSERT INTO alumni (full_name, dob, gender, email, password, phone, address, college, degree, field_of_study, graduation_year, employer, job_title, linkedin, consent)
            VALUES ('$full_name', '$dob', '$gender', '$email', '$password', '$phone', '$address', '$college', '$degree', '$field_of_study', '$graduation_year', '$employer', '$job_title', '$linkedin', '$consent')";

    if ($conn->query($sql) === TRUE) {
        echo "New alumni added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit alumni information when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];

    // Check if each field is set and use a fallback value if not
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $college = isset($_POST['college']) ? $_POST['college'] : '';
    $degree = isset($_POST['degree']) ? $_POST['degree'] : '';
    $field_of_study = isset($_POST['field_of_study']) ? $_POST['field_of_study'] : '';
    $graduation_year = isset($_POST['graduation_year']) ? $_POST['graduation_year'] : '';
    $employer = isset($_POST['employer']) ? $_POST['employer'] : '';
    $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
    $linkedin = isset($_POST['linkedin']) ? $_POST['linkedin'] : '';
    $consent = isset($_POST['consent']) ? 1 : 0; // If consent checkbox is checked, set consent to 1

    // Update query
    $sql = "UPDATE alumni SET full_name='$full_name', dob='$dob', gender='$gender', email='$email', password='$password', 
            phone='$phone', address='$address', college='$college', degree='$degree', field_of_study='$field_of_study',
            graduation_year='$graduation_year', employer='$employer', job_title='$job_title', linkedin='$linkedin', 
            consent='$consent' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch alumni data
$sql = "SELECT * FROM alumni";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Table</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    text-align: center;
    color: orange;
    margin-bottom: 20px;
}

form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

form label {
    font-weight: bold;
    color: #555;
}

form input, form textarea, form select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

form textarea {
    resize: vertical;
    height: 80px;
}

form input[type="submit"] {
    grid-column: span 2;
    background-color: violet;
    color: #fff;
    border: none;
    padding: 10px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 4px;
}

form input[type="submit"]:hover {
    background-color: orange;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 10px;
    border: 1px solid violet;
    text-align: left;
}

table th {
    background-color:orange;
    font-weight: bold;
    color: #333;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

table a {
    color: #007BFF;
    text-decoration: none;
}

table a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>

<div class="container">
    <h1>Alumni Information</h1>

    <!-- Add new alumni form -->
    <h2>Add New Alumni</h2>
    <form method="post">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" required>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone">

        <label for="address">Address:</label>
        <textarea name="address"></textarea>

        <label for="college">College:</label>
        <input type="text" name="college">

        <label for="degree">Degree:</label>
        <input type="text" name="degree">

        <label for="field_of_study">Field of Study:</label>
        <input type="text" name="field_of_study">

        <label for="graduation_year">Graduation Year:</label>
        <input type="number" name="graduation_year">

        <label for="employer">Employer:</label>
        <input type="text" name="employer">

        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title">

        <label for="linkedin">LinkedIn:</label>
        <input type="text" name="linkedin">

        <label for="consent">Consent:</label>
        <input type="checkbox" name="consent">

        <input type="submit" name="add" value="Add Alumni">
    </form>

    <!-- Table displaying alumni data -->
    <h2>Alumni Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>College</th>
                <th>Degree</th>
                <th>Field of Study</th>
                <th>Graduation Year</th>
                <th>Employer</th>
                <th>Job Title</th>
                <th>LinkedIn</th>
                <th>Consent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['dob'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['college'] . "</td>";
                    echo "<td>" . $row['degree'] . "</td>";
                    echo "<td>" . $row['field_of_study'] . "</td>";
                    echo "<td>" . $row['graduation_year'] . "</td>";
                    echo "<td>" . $row['employer'] . "</td>";
                    echo "<td>" . $row['job_title'] . "</td>";
                    echo "<td>" . $row['linkedin'] . "</td>";
                    echo "<td>" . ($row['consent'] == 1 ? 'Yes' : 'No') . "</td>";
                    echo "<td><a href='?edit=" . $row['id'] . "'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
