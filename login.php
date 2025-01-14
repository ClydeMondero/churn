<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Churn System</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
  <?php
  // Include the database connection file
  include('db_connection.php');

  session_start(); // Start the session

  // Check if form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $conn->real_escape_string($_POST['username']);
      $password = $_POST['password'];

      // Query to check if the username exists
      $sql = "SELECT * FROM users WHERE email = '$username'";
      $result = $conn->query($sql);

      if ($result->num_rows == 1) {
          $user = $result->fetch_assoc();

          // Verify the password
          if (password_verify($password, $user['password'])) {
              // Set session variables
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['username'] = $user['name'];

              // Redirect to the dashboard or main page
              header("Location: index.php");
              exit();
          } else {
              $error = "Incorrect password.";
          }
      } else {
          $error = "User does not exist.";
      }
  }
  ?>

  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>
                <p class="text-center">Login</p>

                <!-- Display error message if login fails -->
                <?php if (isset($error)): ?>
                  <p class="text-danger text-center"><?php echo $error; ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" name="username" class="form-control" id="exampleInputEmail1" required>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remember this Device
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="./index.html">Forgot Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 fs-4 mb-4 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New User?</p>
                    <a class="text-primary fw-bold ms-2" href="./register.php">Create an account</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
