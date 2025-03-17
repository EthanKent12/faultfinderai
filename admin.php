<<?php
session_start(); // Start the session

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['AccessID'] != 1) {
    echo "Access denied!";
    exit();
}

include "db.php"; // Include the database connection

// Handle form submission to add a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $access_level = $_POST['access_level'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO credential (Username, PasswordHash, AccessID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $hashed_password, $access_level);

    if ($stmt->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error creating user.";
    }

    $stmt->close();
}

// Fetch all users and roles (access levels)
$sql = "SELECT c.CredentialID, c.Username, a.LevelName FROM credential c
        JOIN access_level a ON c.AccessID = a.AccessID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
             body {
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn-delete {
            color: red;
        }
        .btn-update {
            color: green;
        }
        .btn-redirect {
            background-color: #0e3c65;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
        }
        .btn-redirect:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>

<h2>Welcome, <?= $_SESSION['username']; ?> (Admin)</h2>
<a href="logout.php">Logout</a>

<h3>User Management</h3>

<!-- User Creation Form -->
<div class="form-container">
    <h3>Create New User</h3>
    <form action="admin.php" method="POST">
        <input type="text" class="input-field" name="username" placeholder="Enter Username" required>
        <input type="password" class="input-field" name="password" placeholder="Enter Password" required>
        <select name="access_level" class="input-field" required>
            <option value="">Select Access Level</option>
            <option value="1">Admin</option>
            <option value="2">Developer</option>
            <option value="3">Guest</option>
        </select>
        <button type="submit" class="submit-button">Create User</button>
    </form>
</div>

<h3>Existing Users</h3>
<table>
    <tr>
        <th>Username</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Username'] ?></td>
            <td><?= $row['LevelName'] ?></td>
            <td>
                <a href="update_role.php?id=<?= $row['CredentialID'] ?>">Change Role</a> | 
                <a href="manage_users.php?action=delete&id=<?= $row['CredentialID'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
