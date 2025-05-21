<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "heerpatel";
$dbname = "travel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Validate the ID to prevent SQL injection
    if (is_numeric($delete_id)) {
        // Prepare the SQL to delete the user
        $sql_delete = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $delete_id);

        // Execute and check if deletion was successful
        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Invalid user ID.";
    }

    // Redirect back to admin page after deleting
    header("Location: admin.php");
    exit();
}

$conn->close();
?>
