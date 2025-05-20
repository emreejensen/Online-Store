<?php
session_start();
include 'header.php';
include 'nav.php';
include 'connection.php'; // Use $dbc

$step = 1;
$email = '';
$security_question = '';
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Get security question
    if (isset($_POST['lookup'])) {
        $email = trim($_POST['email']);
        $stmt = $dbc->prepare("SELECT security_question FROM ggc_store_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($security_question);
        if ($stmt->fetch()) {
            $step = 2;
        } else {
            $error = "No user found with that email.";
        }
        $stmt->close();
    }

    // Step 2: Verify answer and reset password
    if (isset($_POST['reset'])) {
        $email = trim($_POST['email']);
        $security_answer = trim($_POST['security_answer']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $stmt = $dbc->prepare("SELECT security_answer FROM ggc_store_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($correct_answer);

        if ($stmt->fetch()) {
            $stmt->close(); // ✅ close only once

            if (strtolower(trim($correct_answer)) === strtolower($security_answer)) {
                if ($new_password === $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $update = $dbc->prepare("UPDATE ggc_store_users SET password = ? WHERE email = ?");
                    $update->bind_param("ss", $hashed_password, $email);
                    if ($update->execute()) {
                        $success = "Password successfully updated. You can now <a href='login.php'>login</a>.";
                    } else {
                        $error = "Something went wrong. Please try again.";
                    }
                    $update->close();
                } else {
                    $error = "Passwords do not match.";
                }
            } else {
                $error = "Security answer is incorrect.";
            }
        } else {
            $error = "Email not found.";
            $stmt->close(); // ✅ only close here if fetch failed
        }
    }
}
?>

<h2>Forgot Password</h2>

<?php if ($error): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>
<?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
<?php endif; ?>

<?php if ($step === 1): ?>
<!-- Step 1: Email Lookup -->
<form method="post" action="forgot_password.php">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit" name="lookup">Next</button>
</form>

<?php elseif ($step === 2): ?>
<!-- Step 2: Security Answer & Reset Password -->
<form method="post" action="forgot_password.php">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

    <?php
    $question_text = match($security_question) {
        'first_pet' => "What was the name of your first pet?",
        'mother_maiden' => "What is your mother's maiden name?",
        'favorite_teacher' => "Who was your favorite teacher?",
        default => "Your security question",
    };
    ?>
    <p><strong>Security Question:</strong> <?= htmlspecialchars($question_text) ?></p>

    <label>Answer:</label><br>
    <input type="text" name="security_answer" required><br><br>

    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br>

    <label>Confirm New Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit" name="reset">Reset Password</button>
</form>
<?php endif; ?>

<?php include 'footer.php'; ?>
