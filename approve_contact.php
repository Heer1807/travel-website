<?php
// Database connection
$host = 'localhost';
$dbname = 'travel';
$username = 'root';
$password = 'heerpatel';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Check if the form is submitted and the 'approve' button is clicked
if (isset($_POST['approve']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Retrieve the contact details from the original 'contact_form' table
    $stmt = $pdo->prepare("SELECT * FROM contact_form WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $contact = $stmt->fetch();

    if ($contact) {
        // Check if the contact already exists in the 'approved_contacts' table
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM approved_contacts WHERE id = :id");
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            // If the contact already exists in the approved_contacts table
            echo "This contact has already been approved!";
        } else {
            // Insert the contact into the 'approved_contacts' table
            $stmt = $pdo->prepare("INSERT INTO approved_contacts (id, name, email, message) 
                                   VALUES (:id, :name, :email, :message)");
            $stmt->bindParam(':id', $contact['id'], PDO::PARAM_INT);
            $stmt->bindParam(':name', $contact['name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $contact['email'], PDO::PARAM_STR);
            $stmt->bindParam(':message', $contact['message'], PDO::PARAM_STR);

            $stmt->execute();

            // Delete the contact from the original 'contact_form' table after approval
            $deleteStmt = $pdo->prepare("DELETE FROM contact_form WHERE id = :id");
            $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $deleteStmt->execute();

            // Redirect back to the contact form page after successful approval
            header('Location: contact_form.php'); // Replace with your redirect URL
            exit;
        }
    } else {
        // Handle case if the contact doesn't exist
        echo "Contact not found!";
    }
} else {
    echo "Invalid request!";
}
?>
