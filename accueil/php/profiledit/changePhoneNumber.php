<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changePhone'])) {
    // Check if the phone number is provided
    if (isset($_POST['NewPhoneNumber'])) {
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

            $newPhoneNumber = $_POST['NewPhoneNumber'];
            $userId = $_SESSION['user_id']; // Get user ID from the session

            // Get the current phone number of the user from the Client table
            $getCurrentPhoneNumberQuery = "SELECT numero_de_telephone_client FROM client WHERE id_client = :userId";
            $stmt = $conn->prepare($getCurrentPhoneNumberQuery);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $currentPhoneNumber = $stmt->fetchColumn();

            // Check if the new phone number is the same as the current one
            if ($newPhoneNumber === $currentPhoneNumber) {
                $_SESSION['phone_error'] = "You have entered the same phone number as before.";
                header("Location: ../profil.php");
                exit();
            }

            // Validate the format of the new phone number
            if (!preg_match('/^(05|06|07)\d{8}$/', $newPhoneNumber)) {
                $_SESSION['phone_error'] = "Please enter a valid Algerian phone number starting with 05, 06, or 07 and containing 10 digits.";
                header("Location: ../profil.php");
                exit();
            }

            // Update the phone number in the Client table
            $update_query = "UPDATE client SET numero_de_telephone_client = :newPhoneNumber WHERE id_client = :userId";
            $stmt = $conn->prepare($update_query);
            $stmt->bindParam(':newPhoneNumber', $newPhoneNumber);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $_SESSION['phone'] = $newPhoneNumber; // Update the phone number in the session
            $_SESSION['success_message_phone'] = "Phone number updated successfully.";
            header("Location: ../profil.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['phone_error'] = "Error: " . $e->getMessage();
            header("Location: ../profil.php");
            exit();
        }
    } else {
        $_SESSION['phone_error'] = "Please fill in all the fields.";
        header("Location: ../profil.php");
        exit();
    }
}
?>
