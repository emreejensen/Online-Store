<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type']; // Capture user type for redirect

// Sanitize input
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$update_password = false;
$update_pic = false;
$profile_pic_path = null;

// Handle password update
if (!empty($new_password)) {
    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password = true;
    } else {
        echo "❌ Passwords do not match.";
        exit();
    }
}

// Handle profile pic upload
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
    $targetDir = "images/";
    $fileName = basename($_FILES["profile_pic"]["name"]);
    $profile_pic_path = $targetDir . time() . "_" . $fileName;
    $imageType = strtolower(pathinfo($profile_pic_path, PATHINFO_EXTENSION));
    $validTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($imageType, $validTypes)) {
        echo "❌ Only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic_path)) {
        $update_pic = true;
    } else {
        echo "❌ Failed to upload profile picture.";
        exit();
    }
}

// Build the update query
$query = "UPDATE ggc_store_users SET first_name=?, last_name=?, phone=?, email=?";
$params = [$first_name, $last_name, $phone, $email];
$types = "ssss";

if ($update_password) {
    $query .= ", password=?";
    $params[] = $hashed_password;
    $types .= "s";
}

if ($update_pic) {
    $query .= ", profile_pic=?";
    $params[] = $profile_pic_path;
    $types .= "s";
}

$query .= " WHERE id=?";
$params[] = $user_id;
$types .= "i";

// Prepare and execute the statement
$stmt = $dbc->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    // Update session if first name/email changed
    $_SESSION['user_first_name'] = $first_name;
    $_SESSION['user_last_name'] = $last_name;
    $_SESSION['email'] = $email;
    if ($update_pic) {
        $_SESSION['user_profile_pic'] = $profile_pic_path;
    }

    // Redirect to correct profile page
    if ($user_type === 'admin') {
        header("Location: admin_profile.php?success=1");
    } else {
        header("Location: student_profile.php?success=1");
    }
    exit();
} else {
    echo "❌ Error updating profile: " . $stmt->error;
}
?>
