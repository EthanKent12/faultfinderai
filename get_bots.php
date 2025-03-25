<?php
require 'db.php'; // Ensure database connection

header("Content-Type: application/json");

$query = "SELECT * FROM product"; // Assuming you have a `bots` table
$result = $conn->query($query);

$bots = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bots[] = [
            "id" => $row['id'],
            "name" => $row['name'],
            "description" => $row['description'],
            "status" => $row['status']
        ];
    }
}

echo json_encode($bots);
$conn->close();
?>
