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

    // SQL to delete the user
    $sql_delete = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
    $stmt->close();
    // Redirect back to admin page after deleting
    header("Location: admin.php");
    exit();
}


// Fetch users from the database
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

$users = [];
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "No users found.";
}

// Fetch contact form data from the database
$sql_contact = "SELECT * FROM contact_form";
$result_contact = $conn->query($sql_contact);

$contacts = [];
if ($result_contact->num_rows > 0) {
    while ($row = $result_contact->fetch_assoc()) {
        $contacts[] = $row;
    }
} else {
    echo "No contact form messages found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VoyageVista - Admin Panel</title>
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
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }

        table td {
            background-color: #fff;
            color: #555;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table button {
            background-color: #1ec6b6;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }

        table button:hover {
            background-color: #0056b3;
        }

        table button:active {
            background-color: #004085;
        }

        /* Centering the Admin Dashboard heading */
        .content {
            text-align: center; /* Centers text inside the div */
            padding: 20px; /* Adds some padding for better spacing */
        }

        .content h2 {
            font-size: 2rem; /* Adjust the font size as needed */
            font-weight: bold; /* Makes the heading bold */
            color: #333; /* Sets the text color */
            margin-bottom: 20px; /* Adds space below the heading */
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
    <!-- End of Navbar -->

    <!-- Header Section -->
    <header class="flex">
        <div class="container">
            <div class="header-title">
                <h1>Admin Panel</h1>
            </div>
        </div>
    </header>
    <!-- Navbar and other sections as per your existing code -->

    <div class="content">
        <h2>Admin Dashboard</h2>

        <!-- User Data Section -->
        <section id="users">
            <h3>User Data</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through the users array and display each user in the table
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['id'] . "</td>";
                        echo "<td>" . $user['username'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td>" . $user['dob'] . "</td>";
                        echo "<td>" . $user['role'] . "</td>";
                        echo "<td>
                                <a href='edit.php?id=" . $user['id'] . "'><button>Edit</button></a> 
                                <a href='delete.php?delete_id=" . $user['id'] . "'><button>Delete</button></a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section id="contact-form">
    <h3>Contact Form Messages</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Action</th> <!-- New column for action -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($contacts as $contact) {
                echo "<tr>";
                echo "<td>" . $contact['id'] . "</td>";
                echo "<td>" . $contact['name'] . "</td>";
                echo "<td>" . $contact['email'] . "</td>";
                echo "<td>" . $contact['message'] . "</td>";
                // Add action buttons (Approve and Delete)
                echo "<td>
                        <form action='approve_contact.php' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $contact['id'] . "' />
                            <button type='submit' name='approve'>Approve</button>
                        </form>
                        <form action='delete_contact.php' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $contact['id'] . "' />
                            <button type='submit' name='delete'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>

    </div>


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
