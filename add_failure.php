<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $testLogID = $_POST["testLogID"];
    $errorDetails = $_POST["errorDetails"];

    $stmt = $pdo->prepare("INSERT INTO failure_log (TestLogID, ErrorDetails) VALUES (?, ?)");
    if ($stmt->execute([$testLogID, $errorDetails])) {
        echo "Test failure recorded.";
    } else {
        echo "Failed to record failure.";
    }
}
?>