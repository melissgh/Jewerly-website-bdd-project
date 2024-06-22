<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['NewFirstName'])) {
        $newFirstName = $_POST['NewFirstName'];

        // Checking if the first name is not empty and has at least 3 characters
        if (empty($newFirstName) || strlen($newFirstName) < 3) {
            $_SESSION['firstname_error'] = "Please enter a first name with at least 3 characters.";
            header("Location:  ../profil.php");
            exit();
        }

        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bddproject";

        try {
            // Connect to the database using PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve user ID from the session
            $user_id = $_SESSION['user_id']; // Assuming user ID is stored in a 'user_id' key

            // Update the first name in the client table
            $update_query = "UPDATE client SET nom_client = :nom WHERE id_client = :id";
            $stmt = $conn->prepare($update_query);
            $stmt->bindParam(':nom', $newFirstName);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            // Update session data
            $_SESSION['nom'] = $newFirstName;

            // Success message
            $_SESSION['success_message_firstname'] = "Your first name has been changed successfully.";

            // Redirect to the profile page
            header("Location:  ../profil.php");
            exit();
        } catch (PDOException $e) {
            // Database error handling
            $_SESSION['firstname_error'] = "Error: " . $e->getMessage();

            // Redirect to the profile page with an error message
            header("Location:  ../profil.php");
            exit();
        }
    } else {
        // Fields not filled
        $_SESSION['firstname_error'] = "Please fill in the first name field.";
        header("Location:  ../profil.php");
        exit();
    }
}
?>
