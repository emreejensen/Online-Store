<?php
session_start();
include 'connection.php';  // Including the connection to the database

// Get form data from the login page
$email = trim($_POST['email']);
$password = $_POST['password'];

// Prepare the SQL query to fetch the user by email
$stmt = mysqli_prepare($dbc, "SELECT * FROM ggc_store_users WHERE email = ?");
if ($stmt === false) {
    die("Error preparing the SQL statement: " . mysqli_error($dbc));
}

mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);

// Store the result
$result = mysqli_stmt_get_result($stmt);

if ($result === false) {
    die("Error executing query: " . mysqli_error($dbc));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        // ✅ Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_type'] = $row['user_type'];
        $_SESSION['user_first_name'] = $row['first_name'];
        $_SESSION['user_last_name'] = $row['last_name'];
        $_SESSION['user_profile_pic'] = $row['profile_pic'];

        // ✅ Handle Remember Me cookie
        if (isset($_POST['remember_me'])) {
            setcookie('remember_email', $email, time() + (86400 * 30), "/"); // 30 days
        } else {
            setcookie('remember_email', '', time() - 3600, "/"); // Clear it
        }

        // ✅ Redirect based on user type
        if ($row['user_type'] == 'student') {
            header("Location: student_home.php");
        } elseif ($row['user_type'] == 'admin') {
            header("Location: admin_dashboard.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Incorrect password.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "No user found with that email address.";
    header("Location: login.php");
    exit();
}

mysqli_stmt_close($stmt);
?>
