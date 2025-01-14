<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
</head>
<body>
  <h2>Reset Password</h2>
  <form method="POST" action="process_forgot_password.php">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" id="email" required>
    
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required>
    
    <button type="submit">Reset Password</button>
  </form>
</body>
</html>
