<?php
session_start();  // Start the session

if ($_SESSION['AccessID'] != 1) {  // Ensure only admin can access
    echo "Access denied!";
    exit();
}

include "db.php";  // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $newRole = $_POST['accessId'];

    // Update the user's access level
    $sql = "UPDATE credential SET AccessID = ? WHERE CredentialID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newRole, $userId);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating role.";
    }
}

$userId = $_GET['id'];
$sql = "SELECT * FROM access_level";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Role</title>
</head>
<body>
    <h2>Change User Role</h2>
    <form method="post">
        <input type="hidden" name="userId" value="<?= $userId ?>">
        <label for="accessId">Select Role:</label>
        <select name="accessId">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['AccessID'] ?>"><?= $row['LevelName'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Update</button>
    </form>
</body>
</html>
