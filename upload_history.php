<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CHURN SYSTEM</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f4f4f4;
    }
</style>
<div class="container-fluid">
    <!-- Row 1 -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 shadow-sm border-0">
                <h5 class="card-title mb-10 fw-semibold">Customer Bank Reviews History</h5>
                <br>

                <div class="container mt-5">
        <h2 class="mb-4 text-center">Review History</h2>

        <!-- Date Picker Filters -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button id="filterBtn" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>

        <!-- Review History Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reviewer Name</th>
                    <th>Review Text</th>
                    <th>Rating</th>
                    <th>Place Name</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="reviewData">
                <!-- Data will be populated here via PHP -->
            </tbody>
        </table>
    </div>


            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function () {
            // Function to filter reviews
            $('#filterBtn').on('click', function () {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                if (startDate && endDate) {
                    $.ajax({
                        url: 'reviews.php', // Back-end file
                        type: 'GET',
                        data: { start_date: startDate, end_date: endDate },
                        success: function (data) {
                            $('#reviewData').html(data); // Populate the table with the response
                        },
                        error: function () {
                            alert('Failed to filter data. Please try again.');
                        }
                    });
                } else {
                    alert('Please select both start and end dates.');
                }
            });
        });
    </script>
<!-- Add DataTables and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#reviewsTable').DataTable({
            "paging": true,        // Enable pagination
            "searching": true,     // Enable search
            "ordering": true,      // Enable sorting
            "info": true,          // Show info (e.g., "Showing 1 to 10 of 100 entries")
            "lengthChange": false, // Disable the "Show entries" dropdown
        });
    });
</script>
