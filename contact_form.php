<?php
// Database credentials
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = 'heerpatel'; // Database password
$database = 'travel'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare SQL query to insert data into database
    $sql = "INSERT INTO contact_form (name, email, message) VALUES (?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to contact.html after successful form submission
            header("Location: contact.html");
            exit; // Ensure no further code is executed
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error preparing query
        echo "Error preparing query: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
