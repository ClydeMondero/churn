<?php
include 'db/config.php';

$query = $pdo->query("SELECT * FROM customer_reviews");
$reviews = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($reviews as $review) {
    $churnRisk = 'Low';

    if ($review['rating'] <= 2) {
        $churnRisk = 'High';
    } elseif ($review['rating'] == 3) {
        $churnRisk = 'Medium';
    }

    $stmt = $pdo->prepare("UPDATE customer_reviews SET churn_risk_level = ? WHERE id = ?");
    $stmt->execute([$churnRisk, $review['id']]);
}

echo "Churn risk analysis completed!";
?>
