<?php
// Include the database connection
include('db_connection.php');
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current user's data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if a password is provided, if yes, hash it
    $password = '';
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE id = '$user_id'";
    } else {
        $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$user_id'";
    }

    // Update the user's profile
    if ($conn->query($sql) === TRUE) {
        echo "<p class='text-success'>Profile updated successfully!</p>";
    } else {
        echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CHURN SYSTEM</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<style>
.card-header {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.card-body p {
    font-size: 1.1em;
}

  </style>
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar" data-simplebar>
        <div class="d-flex mb-4 align-items-center justify-content-between">
            <a href="index.php" class="text-nowrap logo-img ms-0 ms-md-1">
            <h3>Churn System</h3>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav" class="mb-4 pb-2">
        
            <li class="sidebar-item">
              <a
                class="sidebar-link sidebar-link primary-hover-bg"
                href="./index.php"
                aria-expanded="false"
              >
                <span class="aside-icon p-2 bg-light-primary rounded-3">
                  <i class="ti ti-layout-dashboard fs-7 text-primary"></i>
                </span>
                <span class="hide-menu ms-2 ps-1">Home</span>
              </a>


              <a
                class="sidebar-link sidebar-link primary-hover-bg"
                href="./process.php"
                aria-expanded="false"
              >
                <span class="aside-icon p-2 bg-light-primary rounded-3">
                  <i class="ti ti-layout-dashboard fs-7 text-primary"></i>
                </span>
                <span class="hide-menu ms-2 ps-1">Process</span>
              </a>

              <!-- <a
              class="sidebar-link sidebar-link primary-hover-bg"
              href="./index.html"
              aria-expanded="false"
            >
            <span class="aside-icon p-2 bg-light-success rounded-3">
              <i class="ti ti-cards fs-7 text-success"></i>
            </span>
              <span class="hide-menu ms-2 ps-1">Process</span>
            </a> -->


            <a class="sidebar-link sidebar-link primary-hover-bg" href="./upload_history.php" aria-expanded="false" >
          <span class="aside-icon p-2 bg-light-primary rounded-3">
            <i class="ti ti-file-description fs-7 text-primary"></i>
          </span>
            <span class="hide-menu ms-2 ps-1">History</span>
          </a>


          <a class="sidebar-link sidebar-link primary-hover-bg" href="./contact.php" aria-expanded="false" >
          <span class="aside-icon p-2 bg-light-primary rounded-3">
            <i class="ti ti-file-description fs-7 text-primary"></i>
          </span>
            <span class="hide-menu ms-2 ps-1">Contact Us</span>
          </a>
            </li>    
          </ul>   
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>

    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="assets/images/profile/user1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="edit_profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Edit Profile</p>
                    </a>
                    <!-- <a href="forgot_password.php" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">Forgot Password</p>
                    </a> -->
              
                    <a href="login.php" class="btn btn-outline-primary mx-3 mt-2 d-block shadow-none">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>

<body>
  <div class="container">
    <br><br><br><br><br>
    <h2>Edit Profile</h2>
    <form method="POST" action="edit_profile.php">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="<?php echo $user['name']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $user['email']; ?>" required>
      </div>
      <div class="mb-4">
        <label for="password" class="form-label">New Password (Leave blank to keep the current one)</label>
        <input type="password" name="password" class="form-control" id="password">
      </div>
      <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
  </div>

  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
