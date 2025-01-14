<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Execute the Node.js Puppeteer script
        $escaped_url = escapeshellarg($url);
        $output = shell_exec("node scrape_reviews.js $escaped_url");

        // Decode JSON output
        $reviews = json_decode($output, true);
    } else {
        $error = "Invalid URL!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Reviews Scraper</title>
</head>
<body>
    <h1>Google Reviews Scraper</h1>
    <form method="POST">
        <label for="url">Paste Google Maps URL:</label><br>
        <input type="text" name="url" id="url" placeholder="Paste URL here" style="width: 100%;" required>
        <button type="submit">Generate Reviews</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($reviews)): ?>
        <h2>Customer Reviews:</h2>
        <ul>
            <?php foreach ($reviews as $review): ?>
                <li>
                    <strong>Rating:</strong> <?= htmlspecialchars($review['rating']) ?><br>
                    <strong>Review:</strong> <?= htmlspecialchars($review['text']) ?><br>
                    <strong>Date:</strong> <?= htmlspecialchars($review['date']) ?><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
