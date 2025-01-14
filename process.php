<?php
// Assuming you have already set up your database connection
include('db_connection.php');

// Current date (not used here but can be used for date-specific queries)
$currentDate = date('Y-m-d');
// Query to fetch all reviews without grouping
$query = "SELECT reviewer_name, review_text, rating, place_name 
FROM reviews";

// Execute query
$result = mysqli_query($conn, $query);

// Initialize variables
$totalReviews = 0;
$totalRating = 0;
$ratings = [];
$ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
$placeName = 'Unknown Place'; // Default value
$reviews = []; // Array to store review details

if (mysqli_num_rows($result) > 0) {
    // Loop through the results
    while ($row = mysqli_fetch_assoc($result)) {
        $totalReviews++; // Count each review
        $totalRating += $row['rating']; // Add the rating to the total
        $ratings[] = $row['rating']; // Store ratings for distribution charts

        // Save review details
        $reviews[] = [
            'reviewer_name' => $row['reviewer_name'],
            'review_text' => $row['review_text'],
            'rating' => $row['rating']
        ];

        // Assuming all reviews are for the same place
        $placeName = $row['place_name']; // Use the first `place_name` found
    }

    // Calculate average rating
    $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;

    // Count the number of reviews for each rating (1 to 5 stars)
    for ($i = 1; $i <= 5; $i++) {
        $ratingCounts[$i] = count(array_filter($ratings, fn($rating) => $rating == $i));
    }
} else {
    // No reviews found, set defaults
    $totalReviews = 0;
    $averageRating = 0;
    $ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
}

// Close the database connection

mysqli_close($conn);
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CHURN SYSTEM</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <style>
       .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .card-body p {
            font-size: 1.1em;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #responseMessage {
            margin-top: 10px;
            color: green;
        }

        .navbar-nav {
            flex-direction: row;
        }
        #myChart {
            max-width: 500px; /* Set the maximum width */
            max-height: 300px; /* Set the maximum height */
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <aside class="left-sidebar">
            <div class="scroll-sidebar" data-simplebar>
                <div class="d-flex mb-4 align-items-center justify-content-between">
                    <a href="index.php" class="text-nowrap logo-img ms-0 ms-md-1">
                        <h3>Churn System</h3>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="mb-4 pb-2">
                        <li class="sidebar-item">
                            <a class="sidebar-link sidebar-link primary-hover-bg" href="./index.php" aria-expanded="false">
                                <span class="aside-icon p-2 bg-light-primary rounded-3">
                                    <i class="ti ti-layout-dashboard fs-7 text-primary"></i>
                                </span>
                                <span class="hide-menu ms-2 ps-1">Home</span>
                            </a>
                            <a class="sidebar-link sidebar-link primary-hover-bg" href="./process.php" aria-expanded="false">
                                <span class="aside-icon p-2 bg-light-primary rounded-3">
                                    <i class="ti ti-layout-dashboard fs-7 text-primary"></i>
                                </span>
                                <span class="hide-menu ms-2 ps-1">Process</span>
                            </a>
                            <a class="sidebar-link sidebar-link primary-hover-bg" href="./upload_history.php" aria-expanded="false">
                                <span class="aside-icon p-2 bg-light-primary rounded-3">
                                    <i class="ti ti-file-description fs-7 text-primary"></i>
                                </span>
                                <span class="hide-menu ms-2 ps-1">History</span>
                            </a>
                            <a class="sidebar-link sidebar-link primary-hover-bg" href="./contact.php" aria-expanded="false">
                                <span class="aside-icon p-2 bg-light-primary rounded-3">
                                    <i class="ti ti-file-description fs-7 text-primary"></i>
                                </span>
                                <span class="hide-menu ms-2 ps-1">Contact Us</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
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
                                    <a href="edit_profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">Edit Profile</p>
                                    </a>
                                    <a href="login.php" class="btn btn-outline-primary mx-3 mt-2 d-block shadow-none">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                        <div class="card w-100 shadow-sm border-0">
                          
                            <div class="card-body bg-light">
                                <h1>Google Maps Bank Review Scraper</h1>
                                <form id="scrapeForm">
                                    <label for="url">Google Maps URL:</label>
                                    <input type="text" id="url" name="url" required placeholder="Enter Google Maps URL">
                                    <button type="submit">Scrape Reviews</button>
                                </form>
                                <div id="result">
    <p id="loadingMessage">Scraping progress: <span id="progress">0%</span></p>
    <div style="width: 100%; background-color: #f3f3f3; border-radius: 10px;">
        <div id="progressBar" style="width: 0%; background-color: #007bff; height: 20px; border-radius: 10px;"></div>
    </div>
</div>
                                <div id="analytics"></div>

                                <script>
                             document.getElementById('scrapeForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const url = document.getElementById('url').value;
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progress');

        let progress = 0;
        const progressInterval = setInterval(() => {
            if (progress < 90) { // Simulate progress up to 90%
                progress += 10;
                progressBar.style.width = progress + '%';
                progressText.innerText = progress + '%';
            }
        }, 500); // Update every 0.5 seconds

        try {
            const response = await fetch('http://localhost:3000/scrape-reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ url }),
            });

            const data = await response.json();
            clearInterval(progressInterval); // Stop the simulated progress

            if (data.success) {
                progressBar.style.width = '100%';
                progressText.innerText = '100%';
                document.getElementById('result').innerHTML = `<p>Success: ${data.message}</p>`;
                window.location.reload();
            } else {
                document.getElementById('result').innerHTML = `<p>Error: ${data.message}</p>`;
            }
        } catch (error) {
            clearInterval(progressInterval); // Stop the simulated progress
            document.getElementById('result').innerHTML = `<p>Error: Unable to connect to the server.</p>`;
        }
    });
                                </script>

                            </div>
                        </div>
                    </div>


 
         

      

                    <div class="row">
    <div class="col-lg-12 col-md-8 mx-auto">
        <div class="card shadow-lg border-light rounded">
            <div class="card-header text-center bg-primary text-white">
                <h4 class="font-weight-bold">
                    <?php echo $totalReviews; ?> Reviews for <?php echo htmlspecialchars($placeName); ?>
                </h4>
            </div>
            <div class="card-body text-center">
                <h4 class="font-weight-bold">Average Rating</h4>
                <p class="text-muted">Average Rating: 
                    <span class="font-weight-bold text-success">
                        <?php echo number_format($averageRating, 2); ?> / 5
                    </span>
                </p>
            </div>
            <div class="card-footer">
                <h5>All Reviews</h5>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review mb-3 p-3 border rounded">
                            <h6 class="font-weight-bold"><?php echo htmlspecialchars($review['reviewer_name']); ?></h6>
                            <p class="font-italic"><?php echo htmlspecialchars($review['review_text']); ?></p>
                            <p class="text-muted">Rating: 
                                <span class="font-weight-bold text-success">
                                    <?php echo $review['rating']; ?> / 5
                                </span>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No reviews available yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



            

       
            <!-- Chart Section -->
            <div class="col-lg-6 col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2>BAR CHART</h2>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>

                        </div>
                </div>
            </div>
   


        <div class="col-lg-6 col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2>LINE CHART</h2>
                    </div>
                    <div class="card-body">

                        <div class="chart-container">
                            <canvas id="lineChart"></canvas>
                        </div>




                        </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>PIE CHART</h2>
                    </div>
                    <div class="card-body">


                        <div class="chart-container">
    <canvas id="pieChart"></canvas>
</div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    const ratingCounts = <?php echo json_encode($ratingCounts); ?>;
    const labels = Object.keys(ratingCounts);
    const reviewCounts = Object.values(ratingCounts);

    // Chart Configuration
    // Bar Chart
    new Chart(document.getElementById("barChart"), {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Number of Reviews",
                data: reviewCounts,
                backgroundColor: "rgba(75, 192, 192, 0.6)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: "top" },
                title: { display: true, text: "Bar Chart - Review Distribution" }
            },
            scales: {
                x: { title: { display: true, text: "Rating" } },
                y: { title: { display: true, text: "Review Count" }, beginAtZero: true }
            }
        }
    });

// Pie Chart with percentages and labels inside the pie
new Chart(document.getElementById("pieChart"), {
    type: "pie",
    data: {
        labels: labels, // Labels for the Pie Chart (e.g., 1 Star, 2 Stars, etc.)
        datasets: [{
            label: "Percentage of Reviews",
            data: reviewCounts, // Array of review counts
            backgroundColor: [
                "rgba(255, 99, 132, 0.6)", // Red
                "rgba(54, 162, 235, 0.6)", // Blue
                "rgba(255, 206, 86, 0.6)", // Yellow
                "rgba(75, 192, 192, 0.6)", // Green
                "rgba(153, 102, 255, 0.6)"  // Purple
            ],
            borderColor: [
                "rgba(255, 99, 132, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)"
            ],
            borderWidth: 1 // Border width for each pie slice
        }]
    },
    options: {
        responsive: true, // Makes the chart responsive
        plugins: {
            legend: {
                display: true, // Show the legend
                position: "top" // Legend at the top
            },
            title: {
                display: true,
                text: "Pie Chart - Review Percentage"
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((acc, val) => acc + val, 0); // Calculate total reviews
                        const percentage = ((context.raw / total) * 100).toFixed(2); // Calculate percentage
                        return `${context.label}: ${percentage}% (${context.raw} reviews)`; // Tooltip with percentage and count
                    }
                }
            },
            datalabels: {
                color: "#fff", // Text color inside the slices
                formatter: (value, context) => {
                    const total = context.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0); // Total reviews
                    const percentage = ((value / total) * 100).toFixed(1); // Calculate percentage
                    return `${percentage}%`; // Return percentage as label
                },
                font: {
                    weight: "bold", // Make text bold
                    size: 12 // Font size
                },
                align: "center" // Center the text inside the slice
            }
        }
    },
    plugins: [ChartDataLabels] // Enable DataLabels plugin
});



    // Line Chart
new Chart(document.getElementById("lineChart"), {
    type: "line",
    data: {
        labels: labels, // Use the same labels from the bar chart
        datasets: [{
            label: "Number of Reviews",
            data: reviewCounts, // Use the same review counts from the bar chart
            fill: false, // No background fill under the line
            borderColor: "rgba(54, 162, 235, 1)", // Line color
            backgroundColor: "rgba(54, 162, 235, 0.5)", // Point color
            tension: 0.1 // Smooth line tension
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: "top"
            },
            title: {
                display: true,
                text: "Line Chart - Review Trends"
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: "Rating"
                }
            },
            y: {
                title: {
                    display: true,
                    text: "Review Count"
                },
                beginAtZero: true // Start the Y-axis at zero
            }
        }
    }
});

</script>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="assets/js/dashboard.js"></script>
  </body>

</html>