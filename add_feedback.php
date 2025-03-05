<?php
requiire 'db.php';

if ($_server["REQUEST_METHOD"] == "POST") {
    $logID = $_POST["logID"];
    $inputDetails = $_POST["inputDetails"];

    $stmt = $pdo->prepare("INSERT INTO user_input (LogID, InputDetails) VALUES (?, ?)");
    if ($stmt->execute([$logID, $inputDetails])) {
        echo "Feedback added.";
    } else {
        echo "Failed to add feedback.";
    }
}
?>