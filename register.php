<?php 
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $accessID = $_POST["accessID"]; // ensure this exists

    $stmt = $pdo->prepare("INSERT INTO credential (Username, PasswordHash, AccessID) VALUES (?, ?, ?)");
    IF ($stmt->execute([$username, $password, $accessID])) {
        echo "User registered succcessfully.";
    } else {
        echo "Registration failed.";
    }
}
?>