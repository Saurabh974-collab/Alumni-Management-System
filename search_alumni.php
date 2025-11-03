<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "alumni_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for search
$name = isset($_POST['name']) ? $_POST['name'] : '';
$graduation_year = isset($_POST['graduation_year']) ? $_POST['graduation_year'] : '';

// SQL query to search alumni (using prepared statements)
$sql = "SELECT full_name, email, graduation_year, college, degree 
        FROM alumni 
        WHERE (full_name LIKE ? OR ? = '') 
        AND (graduation_year = ? OR ? = '')";

$stmt = $conn->prepare($sql);
$search_name = "%" . $name . "%"; // for LIKE condition
$stmt->bind_param("ssss", $search_name, $name, $graduation_year, $graduation_year);

// Execute and get the result
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Search</title>
    <style>
        /* Global Reset */
        /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4; /* Light background for the page */
    color: #333;
}

/* Header Styles */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: violet;
    border-bottom: 1px solid violet;
}


.logo {
    width: 60px; /* Adjust logo size as necessary */
    /* height: auto; */
    display: block; /* Ensures it behaves like a block element */
    margin: 5px /* Centers the logo */
    
}

/* Navigation Styles */
nav ul {
    list-style-type: none;
    padding: 0px;
    font-size: 20px;
    
}

nav ul li {
    display: inline-block;
    margin: 0 15px; /* Space between links */
   
}

nav ul li a {
    color: black; /* Link color */
    text-decoration: none; /* No underline */
    text-align: center;
}

nav ul li a:hover {
    color:blueviolet; /* Change color on hover */
}

        /* Cards Section */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background-color: #fff;
            width: 250px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            margin: 5px 0;
            color: #555;
        }

        .card .email {
            font-weight: bold;
        }

        .card .degree, .card .college, .card .graduation-year {
            font-style: italic;
        }

        /* Search Bar Styling */
        .search-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #54C392; /* Highlight the border on focus */
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
        header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: violet;
    border-bottom: 1px solid violet;
}


.logo {
    width: 60px; /* Adjust logo size as necessary */
    /* height: auto; */
    display: block; /* Ensures it behaves like a block element */
    margin: 5px /* Centers the logo */
    
}

/* Navigation Styles */
nav ul {
    list-style-type: none;
    padding: 0px;
    font-size: 20px;
    
}

nav ul li {
    display: inline-block;
    margin: 0 15px; 
   
}

nav ul li a {
    color: black; 
    text-decoration: none; 
    text-align: center;
}

nav ul li a:hover {
    color:white; /* Change color on hover */
}
    </style>
</head>
<body>

<header>
        <img src="https://www.mgmmcha.org/images/logos/mgmlogo.png" alt="College Logo" class="logo">
        
        <nav>
            <ul class="list">
                <li><a href="/"><b>Home</b></a></li>
                <li><a href="http://localhost/search_alumni.php"><b>Search Alumni</b></a></li>
                <li><a href="./notable_alumni.html"><b>Notable Alumni</b></a></li>
                <li><a href="gallery.html#gallery"><b>Gallery</b></a></li>
                <li><a href="news.html#news"><b>News</b></a></li>
                <li><a href="./contact.html"><b>Contact Us</b></a></li>
                
            </ul>
        </nav>
    </header>

<h1 style="text-align: center; margin-top: 30px;">Alumni Search</h1>

<!-- Search Form -->
<div class="search-container">
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Search by name" value="<?php echo htmlspecialchars($name); ?>">
        <input type="text" name="graduation_year" placeholder="Graduation Year" value="<?php echo htmlspecialchars($graduation_year); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- Cards Section to Display Results -->
<div class="card-container">
    <?php
    // Display results in cards if any
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>
                    <h3>" . htmlspecialchars($row["full_name"]) . "</h3>
                    <p class='email'>Email: " . htmlspecialchars($row["email"]) . "</p>
                    <p class='graduation-year'>Graduation Year: " . htmlspecialchars($row["graduation_year"]) . "</p>
                    <p class='college'>College: " . htmlspecialchars($row["college"]) . "</p>
                    <p class='degree'>Degree: " . htmlspecialchars($row["degree"]) . "</p>
                  </div>";
        }
    } else {
        echo "<p style='text-align:center; width:100%;'>No alumni found matching the criteria.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>
</div>

</body>
</html>
