<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; // replace with your DB username
$password = "heerpatel"; // replace with your DB password
$dbname = "travel"; // replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input values
    $role = $conn->real_escape_string($_POST['role']);
    $username = $conn->real_escape_string($_POST['username']);
    $user_password = $_POST['password'];

    // Prepare SQL query to check if username and role exist in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND role = '$role'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch user details from DB
        
        // Verify the password (assuming passwords are hashed in the database)
        if (password_verify($user_password, $user['password'])) {
            // Start session and set user info in session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Display login success message
            echo "Login Successful! Welcome, " . $_SESSION['username'] . ". You are logged in as a " . $_SESSION['role'] . ".";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username or role.";
    }
}

// Close connection
$conn->close();
?>
