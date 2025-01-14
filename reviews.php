<?php
// Database Connection
$host = 'localhost';
$db = 'churn';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch Data
$where = "";
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $where = "WHERE DATE(timestamp) BETWEEN :start_date AND :end_date";
}

$sql = "SELECT * FROM reviews_history $where ORDER BY timestamp DESC";
$stmt = $pdo->prepare($sql);

// Bind Parameters if Date Filter is Applied
if (!empty($where)) {
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
}

$stmt->execute();

// Generate Table Rows
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['reviewer_name']) . "</td>
                <td>" . htmlspecialchars($row['review_text']) . "</td>
                <td style='color:" . ($row['rating'] >= 4 ? 'green' : 'red') . "'>" . htmlspecialchars($row['rating']) . "</td>
                <td>" . htmlspecialchars($row['place_name']) . "</td>
                <td>" . htmlspecialchars($row['timestamp']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No reviews found</td></tr>";
}
