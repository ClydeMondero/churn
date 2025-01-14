<?php

// Check if URL is provided in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];

    // Path to the Node.js script (make sure Puppeteer is installed and node is available in your PATH)
    $command = "node scrape_reviews.js \"$url\"";

    // Execute the Node.js script and capture the output
    $output = shell_exec($command);

    // Check if output is valid JSON
    $reviews = json_decode($output, true);

    if (is_array($reviews) && count($reviews) > 0) {
        // Reviews found, display them
        echo '<h2>Reviews:</h2>';
        echo '<ul>';
        foreach ($reviews as $review) {
            echo '<li>';
            echo '<strong>' . htmlspecialchars($review['reviewerName']) . ':</strong><br>';
            echo '<em>Rating: ' . htmlspecialchars($review['rating']) . '</em><br>';
            echo htmlspecialchars($review['reviewText']);
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No reviews found or error in scraping.';
    }
} else {
    // If no URL is posted, show the form
    echo '<form method="POST">
            <label for="url">Enter Google Maps URL:</label><br>
            <input type="text" id="url" name="url" required><br><br>
            <input type="submit" value="Scrape Reviews">
          </form>';
}

?>
