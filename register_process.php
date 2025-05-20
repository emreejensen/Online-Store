<?php
// Include the database connection
require_once('connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $first_name = mysqli_real_escape_string($dbc, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($dbc, $_POST['last_name']);
    $email = mysqli_real_escape_string($dbc, $_POST['email']);
    $phone = mysqli_real_escape_string($dbc, $_POST['phone']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($dbc, $_POST['confirm_password']);
    $security_question = mysqli_real_escape_string($dbc, $_POST['security_question']);
    $security_answer = mysqli_real_escape_string($dbc, $_POST['security_answer']);
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $query = "INSERT INTO ggc_store_users (first_name, last_name, email, phone, password, security_question, security_answer, registration_date) 
              VALUES ('$first_name', '$last_name', '$email', '$phone', '$hashed_password', '$security_question', '$security_answer', NOW())";
    
    $result = mysqli_query($dbc, $query);

    if ($result) {
        // Successfully inserted the user, redirect to login page
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($dbc);
    }
}
?>
