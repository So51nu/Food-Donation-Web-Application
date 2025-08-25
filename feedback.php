<?php
session_start();
include 'connection.php'; // Include the database connection file

if (isset($_POST['send'])) { // Check if the form was submitted
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];

    // Sanitize inputs to prevent SQL injection
    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);

    // Insert query
    $query = "INSERT INTO user_feedback (name, email, message) VALUES ('$sanitized_name', '$sanitized_emailid', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        // Redirect to contact.html with success message
        header("Location: contact.html?success=1");
        exit();
    } else {
        // Redirect to contact.html with failure message
        header("Location: contact.html?success=0");
        exit();
    }
}
?>
