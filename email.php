<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $toEmail = $_POST['toEmail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Use PHP's built-in mail function to send the email
    $headers = 'From: your-email@example.com'; // Replace with your email address
    if (mail($toEmail, $subject, $message, $headers)) {
        http_response_code(200);
        echo 'Email sent successfully!';
    } else {
        http_response_code(500);
        echo 'Error sending email. Please try again.';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>