<?php
// File to store the email subscriptions
$filename = 'subscribers.json';

// Check if form is submitted and email is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Ensure the email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Read the existing data from the JSON file
        if (file_exists($filename)) {
            $json_data = file_get_contents($filename);
            $subscribers = json_decode($json_data, true);
        } else {
            $subscribers = [];
        }

        // Add the new email to the subscribers array
        $subscribers[] = $email;

        // Save the updated array back to the JSON file
        file_put_contents($filename, json_encode($subscribers, JSON_PRETTY_PRINT));

        echo "Thank you for subscribing!";
    } else {
        echo "Invalid email address.";
    }
} else {
    echo "No email provided.";
}
?>
