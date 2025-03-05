<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Guest Login Bypass
    if ($username === 'guest' && $password === 'guest123') {
        $_SESSION['username'] = 'guest';
        $_SESSION['role'] = 'guest';
        header("Location: bot_select.php"); // Redirect to bot selection page
        exit();
    }

    //Normal User Login (Replace with your actual database connection)
    require 'db_connection.php'; // Ensure this file is correctly set up

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Store user role if needed
            header("Location: bot_select.php"); // Redirect to bot selection page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
