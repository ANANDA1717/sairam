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
if (isset($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['roll_no'], $_FILES['photo'])) {
    // Sanitize and prepare the input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $roll_no = $conn->real_escape_string($_POST['roll_no']);

    // Handle the uploaded photo
    $photo = $_FILES['photo'];
    $photo_name = $photo['name'];
    $photo_tmp_name = $photo['tmp_name'];
    $photo_size = $photo['size'];
    $photo_type = $photo['type'];
    $photo_error = $photo['error'];

    // Check if the photo was uploaded successfully
    if ($photo_error === 0) {
        // Move the uploaded photo to a directory
        $upload_dir = 'uploads/'; // Change to your desired upload directory
        $photo_path = $upload_dir . $photo_name;
        move_uploaded_file($photo_tmp_name, $photo_path);
    } else {
        echo "Error uploading photo: " . $photo_error;
        exit;
    }

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO userprofile (name, email, mobile, roll_no, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssss", $name, $email, $mobile, $roll_no, $photo_path);

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