<?php
session_start();
include 'nav.php';
include 'header.php';
?>
<h2>Register</h2>
<form method="post" action="register_process.php">
    <!-- First Name -->
    <label>First Name:</label><br>
    <input type="text" name="first_name" required><br>

    <!-- Last Name -->
    <label>Last Name:</label><br>
    <input type="text" name="last_name" required><br>

    <!-- Email -->
    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <!-- Phone -->
    <label>Phone:</label><br>
    <input type="text" name="phone" required><br>

    <!-- Password -->
    <label>Password:</label><br>
    <input type="password" name="password" required><br>

    <!-- Confirm Password -->
    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br>

    <!-- Security Question -->
    <label>Security Question:</label><br>
    <select name="security_question" id="security_question" required>
        <option value="">--Select a question--</option>
        <option value="first_pet">What was the name of your first pet?</option>
        <option value="mother_maiden">What is your mother's maiden name?</option>
        <option value="favorite_teacher">Who was your favorite teacher?</option>
        <option value="custom">Create your own question</option>
    </select><br>

    <!-- Custom Security Question (only shows when 'Create your own question' is selected) -->
    <div id="custom_question_container" style="display:none;">
        <label for="custom_security_question">Enter your custom security question:</label><br>
        <input type="text" name="custom_security_question" id="custom_security_question"><br>
    </div>

    <!-- Answer to Security Question -->
    <label>Answer:</label><br>
    <input type="text" name="security_answer" required><br><br>

    <button type="submit">Register</button>
</form>

<!-- Include Footer -->
<?php include 'footer.php'; ?>

<script>
    // JavaScript to toggle visibility of custom security question input
    document.getElementById('security_question').addEventListener('change', function() {
        var customQuestionContainer = document.getElementById('custom_question_container');
        if (this.value === 'custom') {
            customQuestionContainer.style.display = 'block';
        } else {
            customQuestionContainer.style.display = 'none';
        }
    });
</script>

