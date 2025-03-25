<?php
require 'db.php';  // Include database connection

header('Content-Type: application/json');

$query = "SELECT CredentialID, Username, AccessID FROM credential";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
} else {
    echo json_encode(["message" => "No users found"]);
}

$conn->close();
?>
