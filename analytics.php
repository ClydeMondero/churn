<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'churn'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all banks for the dropdown
$banksQuery = "SELECT DISTINCT bank FROM customer_reviews";
$stmt = $pdo->query($banksQuery);
$banks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Default bank if not selected
$selectedBank = isset($_POST['bank']) ? $_POST['bank'] : '';

// Fetch analytics based on the selected bank
if ($selectedBank) {
    // Fetch total number of reviews for selected bank
    $totalReviewsQuery = "SELECT COUNT(*) as total_reviews FROM customer_reviews WHERE bank = :bank";
    $stmt = $pdo->prepare($totalReviewsQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $totalReviews = $stmt->fetch(PDO::FETCH_ASSOC)['total_reviews'];

    // Fetch count of good reviews (rating 4 or 5) for selected bank
    $goodReviewsQuery = "SELECT COUNT(*) as good_reviews FROM customer_reviews WHERE bank = :bank AND rating >= 4";
    $stmt = $pdo->prepare($goodReviewsQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $goodReviews = $stmt->fetch(PDO::FETCH_ASSOC)['good_reviews'];

    // Fetch count of bad reviews (rating 1 to 3) for selected bank
    $badReviewsQuery = "SELECT COUNT(*) as bad_reviews FROM customer_reviews WHERE bank = :bank AND rating BETWEEN 1 AND 3";
    $stmt = $pdo->prepare($badReviewsQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $badReviews = $stmt->fetch(PDO::FETCH_ASSOC)['bad_reviews'];

    // Fetch average rating for selected bank
    $averageRatingQuery = "SELECT AVG(rating) as average_rating FROM customer_reviews WHERE bank = :bank";
    $stmt = $pdo->prepare($averageRatingQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $averageRating = round($stmt->fetch(PDO::FETCH_ASSOC)['average_rating'], 2);

    // Fetch reviews data over time (for line graph)
    $reviewsOverTimeQuery = "SELECT DATE(date) as review_date, COUNT(*) as review_count FROM customer_reviews WHERE bank = :bank GROUP BY DATE(date)";
    $stmt = $pdo->prepare($reviewsOverTimeQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $reviewsOverTime = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for line graph
    $reviewDates = [];
    $reviewCounts = [];
    foreach ($reviewsOverTime as $review) {
        $reviewDates[] = $review['review_date'];
        $reviewCounts[] = $review['review_count'];
    }

    // Fetch rating distribution for the pie chart
    $ratingDistributionQuery = "SELECT rating, COUNT(*) as rating_count FROM customer_reviews WHERE bank = :bank GROUP BY rating";
    $stmt = $pdo->prepare($ratingDistributionQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $ratingDistribution = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for pie chart
    $ratingLabels = [];
    $ratingCounts = [];
    foreach ($ratingDistribution as $rating) {
        $ratingLabels[] = $rating['rating'];
        $ratingCounts[] = $rating['rating_count'];
    }

    // Fetch useful count for the bar graph
    $usefulCountQuery = "SELECT author, useful_count FROM customer_reviews WHERE bank = :bank ORDER BY useful_count DESC LIMIT 5";
    $stmt = $pdo->prepare($usefulCountQuery);
    $stmt->bindParam(':bank', $selectedBank);
    $stmt->execute();
    $mostUsefulReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for bar chart
    $usefulAuthors = [];
    $usefulCounts = [];
    foreach ($mostUsefulReviews as $review) {
        $usefulAuthors[] = $review['author'];
        $usefulCounts[] = $review['useful_count'];
    }
} else {
    // Default values when no bank is selected
    $totalReviews = 0;
    $goodReviews = 0;
    $badReviews = 0;
    $averageRating = 0;
    $reviewDates = [];
    $reviewCounts = [];
    $ratingLabels = [];
    $ratingCounts = [];
    $usefulAuthors = [];
    $usefulCounts = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Customer Reviews</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            padding-top: 30px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="mb-4">Customer Reviews Analytics</h2>

        <!-- Dropdown for Bank Selection -->
        <form method="POST" action="">
            <div class="mb-4">
                <label for="bank" class="form-label">Select Bank:</label>
                <select name="bank" id="bank" class="form-select" onchange="this.form.submit()">
                    <option value="">Select a Bank</option>
                    <?php foreach ($banks as $bank): ?>
                        <option value="<?php echo htmlspecialchars($bank['bank']); ?>" <?php echo ($selectedBank == $bank['bank']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($bank['bank']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if ($selectedBank): ?>
            <h3>Analytics for Bank: <strong><?php echo htmlspecialchars($selectedBank); ?></strong></h3>

            <!-- Total Reviews -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Total Reviews</h5>
                </div>
                <div class="card-body">
                    <p>Total Reviews: <strong><?php echo $totalReviews; ?></strong></p>
                </div>
            </div>

            <!-- Good Reviews -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Good Reviews (Rating 4 or 5)</h5>
                </div>
                <div class="card-body">
                    <p>Good Reviews: <strong><?php echo $goodReviews; ?></strong></p>
                </div>
            </div>

            <!-- Bad Reviews -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Bad Reviews (Rating 1 to 3)</h5>
                </div>
                <div class="card-body">
                    <p>Bad Reviews: <strong><?php echo $badReviews; ?></strong></p>
                </div>
            </div>

            <!-- Average Rating -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Average Rating</h5>
                </div>
                <div class="card-body">
                    <p>Average Rating: <strong><?php echo $averageRating; ?></strong></p>
                </div>
            </div>

            <!-- Line Graph (Reviews Over Time) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Reviews Over Time</h5>
                </div>
                <div class="card-body">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart (Rating Distribution) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Rating Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart (Most Useful Reviews) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Most Useful Reviews</h5>
                </div>
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        <?php else: ?>
            <p>Please select a bank to view the analytics.</p>
        <?php endif; ?>

    </div>

    <script>
        // Line Chart (Reviews Over Time)
        var ctxLine = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($reviewDates); ?>,
                datasets: [{
                    label: 'Reviews Over Time',
                    data: <?php echo json_encode($reviewCounts); ?>,
                    borderColor: '#4CAF50',
                    fill: false
                }]
            }
        });

        // Pie Chart (Rating Distribution)
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($ratingLabels); ?>,
                datasets: [{
                    label: 'Rating Distribution',
                    data: <?php echo json_encode($ratingCounts); ?>,
                    backgroundColor: ['#FF5733', '#FFC300', '#FFEB3B', '#4CAF50', '#2196F3']
                }]
            }
        });

        // Bar Chart (Most Useful Reviews)
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($usefulAuthors); ?>,
                datasets: [{
                    label: 'Useful Count',
                    data: <?php echo json_encode($usefulCounts); ?>,
                    backgroundColor: '#FF5733',
                    borderColor: '#FF5733',
                    borderWidth: 1
                }]
            }
        });
    </script>

</body>
</html>
