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
if (isset($_POST['uname'], $_POST['upassword'])) {
    // Sanitize and prepare the input data
    $uname = $conn->real_escape_string($_POST['uname']);
    $upassword = $conn->real_escape_string($_POST['upassword']); // Assuming apassword is the password field

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO userlogin(uname, upassword) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $uname, $upassword);

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
?>