<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews Scraper</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .reviews {
            margin-top: 20px;
        }
        .review {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #007BFF;
            font-size: 1.2em;
        }
        p {
            margin: 10px 0;
        }
        hr {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Customer Reviews Scraper</h1>
    <form action="scrape_reviews.php" method="POST">
        <div class="form-group">
            <label for="url">Paste Google Maps URL:</label>
            <input type="text" name="url" id="url" placeholder="Paste the Google Maps URL here" required>
        </div>
        <button type="submit">Get Reviews</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the URL from the form
        $url = $_POST["url"];

        // Call the scraping function and get reviews (make sure this part is working)
        $reviews = scrape_reviews_from_url($url); // You will write this function in the next step

        // If reviews are found, display them
        if (!empty($reviews)) {
            echo "<h2>Customer Reviews</h2>";
            echo "<div class='reviews'>";
            foreach ($reviews as $review) {
                echo "<div class='review'>";
                echo "<h3>" . htmlspecialchars($review['reviewerName']) . "</h3>";
                echo "<p><strong>Rating: </strong>" . str_repeat("&#9733;", $review['rating']) . "</p>";
                echo "<p><strong>Review: </strong>" . nl2br(htmlspecialchars($review['reviewText'])) . "</p>";
                echo "</div><hr>";
            }
            echo "</div>";
        } else {
            echo "<p>No reviews found or invalid URL.</p>";
        }
    }

    // Function to scrape reviews (this is a placeholder for your scraping logic)
    function scrape_reviews_from_url($url) {
        // Placeholder: You need to implement the actual scraping here using your Node.js scraping logic
        // Here, I will just return some dummy data for illustration
        return [
            [
                'reviewerName' => 'Norbert Christian Almario',
                'reviewText' => 'No review text',
                'rating' => 5
            ],
            [
                'reviewerName' => 'G. A. Mendoza',
                'reviewText' => 'No review text',
                'rating' => 5
            ],
            [
                'reviewerName' => 'Nate Brooks',
                'reviewText' => 'No review text',
                'rating' => 5
            ]
        ];
    }
    ?>

</div>

</body>
</html>
