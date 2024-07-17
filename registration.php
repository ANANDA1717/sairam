<?php
// Define database connection parameters as constants
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Add your database password here
define('DB_NAME', 'examination'); // Change to 'examination' or your database name

// Create a connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the POST request contains the required data
if (isset($_POST['fname'], $_POST['fpassword'], $_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['city'], $_POST['dob'])) {
    // Sanitize and prepare the input data
    
   
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $city = $conn->real_escape_string($_POST['city']);
    $dob = $conn->real_escape_string($_POST['dob']);

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO registation.php ( name, email, mobile, city, dob) VALUES ( ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssssss",  $name, $email, $mobile, $city, $dob);

        if ($stmt->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Error executing the statement: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?