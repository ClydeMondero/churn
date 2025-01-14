<?php
// Initialize an empty reviews array
$reviews = [];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the URL from the form input
    $url = trim($_POST['url']);

    // Validate the URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Step 1: Initialize cURL
        $ch = curl_init($url);

        // Step 2: Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept-Language: en-US,en;q=0.9',
            'Accept-Encoding: gzip, deflate, br',
        ]);

        // Step 3: Execute cURL request
        $html = curl_exec($ch);
        curl_close($ch);

        // Step 4: Check if HTML was fetched successfully
        if ($html === false) {
            echo "Failed to fetch content.";
        } else {
            // Load HTML into DOMDocument
            libxml_use_internal_errors(true); // Suppress HTML parsing errors
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            libxml_clear_errors();

            // Step 5: Use DOMXPath to navigate the HTML
            $xpath = new DOMXPath($dom);

            // Step 6: Define the XPath query for customer reviews
            // Adjusting to capture both title and reviews
            $titles = $xpath->query('//div[@class="review-title"]');
            $ratings = $xpath->query('//ul[contains(@class, "review-rate")]');

            // Step 7: Extract and store reviews
            foreach ($titles as $index => $titleNode) {
                $title = trim($titleNode->nodeValue);
                
                // For rating and review count, you might want to extract from the corresponding <ul>
                $ratingNode = $ratings->item($index); // This assumes the structure matches
                $rating = $ratingNode ? trim($ratingNode->nodeValue) : 'No Rating';

                // Store review in an array
                $reviews[] = ['title' => $title, 'rating' => $rating];
            }
        }
    } else {
        echo "Invalid URL provided.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Scraper</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 10px;
            margin-right: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
        }
        .review {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Review Scraper</h1>
<form method="post">
    <input type="text" name="url" placeholder="Enter URL" required>
    <input type="submit" value="Scrape Reviews">
</form>

<h2>Reviews:</h2>
<?php
// Step 8: Display the reviews
if (!empty($reviews)) {
    foreach ($reviews as $review) {
        echo "<div class='review'>";
        echo "<strong>Title:</strong> " . htmlspecialchars($review['title']) . "<br>";
        echo "<strong>Rating:</strong> " . htmlspecialchars($review['rating']) . "<br>";
        echo "</div>";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "No reviews found or XPath query might need adjustment.";
}
?>

</body>
</html>
