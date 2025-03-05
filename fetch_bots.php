<?php
require 'db.php';

$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt>execute();
$result = $stmt->get_result();

$bots = [];

while ($row = $result->fetch_assoc()) {
    $bots[] = $row;
}

echo json_encode($bots);
?>