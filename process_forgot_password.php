<?php
include('db_connection.php'); // Connect to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize inputs
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    
    if (empty($email) || empty($new_password)) {
        echo "Email and password cannot be empty.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Prepare SQL query to check if the email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" denotes the type (string) of the parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, update the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Prepare SQL query to update the password
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);

        if ($update_stmt->execute()) {
            // Redirect to login page after successful password update
            header("Location: login.php");
            exit;
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "User not found.";
    }
}
?>
