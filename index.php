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
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Header */
        header {
            text-align: center;
            padding: 20px 0;
        }
        header h1 {
            font-size: 2em;
            color: #3a86ff;
            margin-bottom: 10px;
        }
        header p {
            font-size: 1.2em;
            color: #555;
        }

        /* Hero Section */
        .hero {
            background-color: #3a86ff;
            color: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }
        .hero h2 {
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        .hero p {
            font-size: 1.1em;
            line-height: 1.6;
        }

        /* Features Section */
        .features {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .feature-card {
            flex: 1;
            background-color: #e0e5ec;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .feature-card h3 {
            font-size: 1.4em;
            margin-bottom: 10px;
            color: #3a86ff;
        }
        .feature-card p {
            font-size: 1em;
            color: #333;
        }

        /* Button Styling */
        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 1em;
            color: white;
            background-color: #3a86ff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: #265f9d;
        }

        .start-process-button {
    margin-top: 10px;
    background-color: #28a745; /* Green color */
    font-weight: bold;
    transition: transform 0.2s, background-color 0.3s;
}

.start-process-button:hover {
    background-color: #218838;
    transform: scale(1.05);
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>Prescriptive Analytics for Customer Churn</h1>
            <p>Using Web Scraping to Understand and Predict Customer Retention in Online Banking</p>
        </header>

        <div class="hero">
    <h2>Empowering Banks with Data-Driven Insights</h2>
    <p>Our project leverages advanced data analytics and web scraping to gather customer reviews and analyze behavior patterns, offering predictive insights to reduce customer churn and improve retention strategies in online banking.</p>
    <button class="cta-button">Get Started</button>
    <button class="cta-button start-process-button">Start Process</button> <!-- New button -->
</div>
        <!-- Features Section -->
        <div class="features">
            <div class="feature-card">
                <h3>Data Collection</h3>
                <p>Automated web scraping of customer feedback from public forums and reviews, ensuring real-time data for effective analysis.</p>
            </div>
            <div class="feature-card">
                <h3>Predictive Analytics</h3>
                <p>Analyze customer data and trends using machine learning models to forecast churn risks and understand customer behavior.</p>
            </div>
            <div class="feature-card">
                <h3>Retention Strategies</h3>
                <p>Gain actionable insights to implement proactive retention strategies based on analytical findings.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for Interactivity -->
    <script>
     document.querySelector(".start-process-button").addEventListener("click", function() {
    // Redirect to process page
    window.location.href = './process.php';
});

    </script>

    

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
