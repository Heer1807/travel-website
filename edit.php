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

// Check if an ID is provided for editing
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details from database
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Check if user exists
    if (!$user) {
        echo "User not found!";
        exit;
    }
}

// Handle form submission for updating user
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET username = '$username', email = '$email', dob = '$dob', role = '$role' WHERE id = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "User updated successfully!";
        header('Location: admin.php'); // Redirect to admin page after successful update
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VoyageVista - Edit</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- fonts -->
    <link rel="stylesheet" href="font/fonts.css">
    <!-- normalize css -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- custom css -->
    <link rel="stylesheet" href="css/utility.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        /* General styling for the content section */
.content {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Styling the header */
.content h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Styling the form */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Input and select field styling */
label {
    font-size: 1rem;
    color: #333;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="date"],
select {
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="date"]:focus,
select:focus {
    border-color: #007BFF;
}

/* Submit button styling */
button[type="submit"] {
    background-color: #1ec6b6;
    color: white;
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 20px;
}

button[type="submit"]:hover {
    background-color: #1ec6b6;
}

button[type="submit"]:active {
    background-color: #004085;
}

/* Ensure the form is responsive */
@media (max-width: 768px) {
    .content {
        width: 90%;
        padding: 15px;
    }

    button[type="submit"] {
        padding: 10px 15px;
    }
}

    </style>
</head>
<body>
<nav class="navbar">
        <div class="container flex">
            <a href="index.html" class="site-brand">
                Voyage<span>Vista</span>
            </a>
            <button type="button" id="navbar-show-btn" class="flex">
                <i class="fas fa-bars"></i>
            </button>
            <div id="navbar-collapse">
                <button type="button" id="navbar-close-btn" class="flex">
                    <i class="fas fa-times"></i>
                </button>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="gallery.html" class="nav-link">Gallery</a></li>
                    <li class="nav-item"><a href="blog1.html" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="signup.html" class="nav-link">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="flex">
        <div class="container">
            <div class="header-title">
                <h1>Edit Panel</h1>
            </div>
        </div>
    </header>
    <div class="content">
        <h2>Edit User</h2>

        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= $user['username']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?= $user['dob']; ?>" required><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select><br>

            <button type="submit" name="update">Update User</button>
        </form>
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <footer class = "py-4">
    <div class = "container footer-row">
        <div class = "footer-item">
            <a href = "index.html" class = "site-brand">
                Voyage<span>Vista</span>
            </a>
            <p class = "text">Voyage Vista is a travel website designed to inspire users by showcasing popular destinations, offering travel services, and facilitating subscriptions for exclusive deals and updates. It features user-friendly navigation, a subscription form, testimonials, and links to social media, all within a responsive design for an engaging experience.</p>
        </div>

        <div class = "footer-item">
            <h2>Follow us on: </h2>
            <ul class = "social-links">
                <li>
                    <a href = "#">
                        <i class = "fab fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <i class = "fab fa-instagram"></i>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <i class = "fab fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <i class = "fab fa-pinterest"></i>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <i class = "fab fa-google-plus"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class = "footer-item">
            <h2>Popular Places:</h2>
            <ul>
                <li><a href = "#">Thailand</a></li>
                <li><a href = "#">Australia</a></li>
                <li><a href = "#">Maldives</a></li>
                <li><a href = "#">Switzerland</a></li>
                <li><a href = "#">Germany</a></li>
            </ul>
        </div>

        <div class="subscribe-form footer-item">
            <h2>Subscribe for Newsletter!</h2>
            <form action="subscribe.php" method="POST" class="flex">
                <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
                <input type="submit" class="btn" value="Subscribe">
            </form>
        </div>
    </div>
    </footer>


    <script src="js/script.js"></script>
</body>
</html>
