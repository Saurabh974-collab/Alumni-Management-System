<?php
// Database connection
$servername = "localhost";
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "alumni_db";      // Database name for the Alumni Tracking System

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape inputs to protect against SQL injection
    $full_name = $conn->real_escape_string($_POST['full-name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['pass'], PASSWORD_BCRYPT); // Encrypt password
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $college = $conn->real_escape_string($_POST['college']);
    $degree = $conn->real_escape_string($_POST['degree']);
    $field_of_study = $conn->real_escape_string($_POST['field-of-study']);
    $graduation_year = $_POST['graduation-year'];
    $employer = $conn->real_escape_string($_POST['employer']);
    $job_title = $conn->real_escape_string($_POST['job-title']);
    $linkedin = $conn->real_escape_string($_POST['linkedin']);
    $consent = isset($_POST['consent']) ? 1 : 0;

    // Insert data into alumni table
    $sql = "INSERT INTO alumni (
                full_name, dob, gender, email, password, phone, address, 
                college, degree, field_of_study, graduation_year, 
                employer, job_title, linkedin, consent
            ) VALUES (
                '$full_name', '$dob', '$gender', '$email', '$password', 
                '$phone', '$address', '$college', '$degree', 
                '$field_of_study', '$graduation_year', '$employer', 
                '$job_title', '$linkedin', '$consent'
            )";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
   
    // Close the connection
    $conn->close();
    

}
?>
