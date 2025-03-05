<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $_POST["productID"];
    $interactionDetails = $_POST["interactionDetails"];

    $stmt = $pdo->prepare("INSERT INTO ai_interaction_log (ProductID, InteractionDetails) VALUES (?, ?)");
    IF ($stmt->execute([$productID, $interactionDetails])) {
        echo "AI interaction logged successfully.";
    } else {
        echo "Failed to log AI interaction."
    }
}
?>