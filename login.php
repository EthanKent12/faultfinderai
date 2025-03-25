<?php
require 'db.php';  // Include the database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "SELECT CredentialID, Username, PasswordHash, Role FROM credential WHERE Username = '$username'";
    $result = $conn->query($query);    

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Assuming password hashing is used
        if (password_verify($password, $user['PasswordHash'])) {
            session_start();
            $_SESSION['user_id'] = $user['CredentialID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role']; // Store user role
        
            // Send the role in the response
            echo json_encode(["status" => "success", "message" => "Login successful", "role" => $user['Role']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password"]);
        }        
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
}

$conn->close();
?>
