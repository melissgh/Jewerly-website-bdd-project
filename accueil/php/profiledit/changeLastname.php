<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['NewLastName'])) {
        $newLastName = $_POST['NewLastName'];

        // Checking if the last name is not empty and has at least 3 characters
        if (empty($newLastName) || strlen($newLastName) < 3) {
            $_SESSION['lastname_error'] = "Please enter a last name with at least 3 characters.";
            header("Location: ../profil.php");
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

            // Update the last name in the client table
            $update_query = "UPDATE client SET prenom_client = :prenom WHERE id_client = :id";
            $stmt = $conn->prepare($update_query);
            $stmt->bindParam(':prenom', $newLastName);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            // Update session data
            $_SESSION['prenom'] = $newLastName;

            // Success message
            $_SESSION['success_message_lastname'] = "Your last name has been changed successfully.";

            // Redirect to the profile page
            header("Location: ../profil.php");
            exit();
        } catch (PDOException $e) {
            // Database error handling
            $_SESSION['lastname_error'] = "Error: " . $e->getMessage();

            // Redirect to the profile page with an error message
            header("Location: ../profil.php");
            exit();
        }
    } else {
        // Fields not filled
        $_SESSION['lastname_error'] = "Please fill in the last name field.";
        header("Location: ../profil.php");
        exit();
    }
}
?>
