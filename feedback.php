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
if (isset($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['message'])) {
    // Sanitize and prepare the input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $message = $conn->real_escape_string($_POST['message']);

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO feedback (name, email, mobile, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ssss", $name, $email, $mobile, $message);

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