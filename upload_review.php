<?php
// Database configuration
$host = 'localhost';
$dbname = 'churn';
$username = 'root';
$password = '';

// Test the database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle the CSV file upload
if (isset($_POST['submit'])) {
    if (isset($_FILES['file']['tmp_name'])) {
        $file = fopen($_FILES['file']['tmp_name'], 'r');
        
        // Skip header row
        fgetcsv($file);

        while (($data = fgetcsv($file)) !== FALSE) {
            // echo "<pre>";
            // print_r($data); // Check the content of the current row
            // echo "</pre>";

            if (count($data) >= 10) {
                // Sanitize and assign the CSV data to variables
                $author = htmlspecialchars($data[0]);
                $date = htmlspecialchars($data[1]);
                $address = htmlspecialchars($data[2]);
                $bank = htmlspecialchars($data[3]);
                $rating = htmlspecialchars($data[4]);
                $review_title_by_user = htmlspecialchars($data[5]);
                $review = htmlspecialchars($data[6]);
                $bank_image = htmlspecialchars($data[7]);
                $rating_title_by_user = htmlspecialchars($data[8]);
                $useful_count = htmlspecialchars($data[9]);

                // Insert into customer_reviews table
                $sql_reviews = "INSERT INTO customer_reviews 
                                (author, date, address, bank, rating, review_title_by_user, review, bank_image, rating_title_by_user, useful_count) 
                                VALUES 
                                (:author, :date, :address, :bank, :rating, :review_title_by_user, :review, :bank_image, :rating_title_by_user, :useful_count)";
                
                $stmt_reviews = $pdo->prepare($sql_reviews);
                $stmt_reviews->bindParam(':author', $author);
                $stmt_reviews->bindParam(':date', $date);
                $stmt_reviews->bindParam(':address', $address);
                $stmt_reviews->bindParam(':bank', $bank);
                $stmt_reviews->bindParam(':rating', $rating);
                $stmt_reviews->bindParam(':review_title_by_user', $review_title_by_user);
                $stmt_reviews->bindParam(':review', $review);
                $stmt_reviews->bindParam(':bank_image', $bank_image);
                $stmt_reviews->bindParam(':rating_title_by_user', $rating_title_by_user);
                $stmt_reviews->bindParam(':useful_count', $useful_count);

                try {
                    $stmt_reviews->execute();
                } catch (PDOException $e) {
                    echo "Error inserting into customer_reviews: " . $e->getMessage();
                    continue; // Skip the current row if there's an error
                }

                // Insert into upload_history table
                $sql_history = "INSERT INTO upload_history 
                                (author, date, address, bank, rating, review_title_by_user, review, bank_image, rating_title_by_user, useful_count, upload_date) 
                                VALUES 
                                (:author, :date, :address, :bank, :rating, :review_title_by_user, :review, :bank_image, :rating_title_by_user, :useful_count, NOW())";
                
                $stmt_history = $pdo->prepare($sql_history);
                $stmt_history->bindParam(':author', $author);
                $stmt_history->bindParam(':date', $date);
                $stmt_history->bindParam(':address', $address);
                $stmt_history->bindParam(':bank', $bank);
                $stmt_history->bindParam(':rating', $rating);
                $stmt_history->bindParam(':review_title_by_user', $review_title_by_user);
                $stmt_history->bindParam(':review', $review);
                $stmt_history->bindParam(':bank_image', $bank_image);
                $stmt_history->bindParam(':rating_title_by_user', $rating_title_by_user);
                $stmt_history->bindParam(':useful_count', $useful_count);

                try {
                    $stmt_history->execute();
                } catch (PDOException $e) {
                    echo "Error inserting into upload_history: " . $e->getMessage();
                    continue; // Skip the current row if there's an error
                }
            } else {
                echo "Skipping invalid row: ";
          
            }
        }

        fclose($file);
        echo "File processed successfully.";
    } else {
        echo "No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Customer Reviews</title>
</head>
<body>
    <h2>Upload Customer Reviews CSV</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept=".csv" required>
        <button type="submit" name="submit">Upload</button>
    </form>
</body>
</html>
