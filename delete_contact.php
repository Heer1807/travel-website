<?php
// Database connection details
$host = 'localhost';
$dbname = 'travel';  // Replace with your actual database name
$username = 'root';         // Replace with your actual username
$password = 'heerpatel';             // Replace with your actual password

try {
    // Create a PDO instance and establish the database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error if connection fails
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Check if the delete form is submitted and 'id' is set
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete query for the contact
    $stmt = $pdo->prepare("DELETE FROM contact_form WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirect back to the contact form page after successful deletion
        header('Location: admin.php'); // Replace with your redirect URL
        exit;
    } else {
        // If there was an error with deletion
        echo "Error: Contact could not be deleted.";
    }
} else {
    echo "Invalid request!";
}
?>
