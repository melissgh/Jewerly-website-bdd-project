<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['address']) || isset($_POST['wilaya'])) {
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

            // Retrieve the user's current data
            $getCurrentDataQuery = "SELECT adresse_client, wilaya_client FROM client WHERE id_client = :id";
            $stmt = $conn->prepare($getCurrentDataQuery);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            // New data submitted by the user
            $newAddress = isset($_POST['address']) ? $_POST['address'] : $userData['adresse_client'];
            $newWilaya = isset($_POST['wilaya']) ? $_POST['wilaya'] : $userData['wilaya_client'];

            // Check if the data has been modified
            if ($newAddress === $userData['adresse_client'] && $newWilaya === $userData['wilaya_client']) {
                // The data is the same as the previously stored one, return an error
                $_SESSION['address_error'] = "You have just entered the same address as before.";
                header("Location: ../profil.php");
                exit();
            }

            // Update the address in the database
            $update_query = "UPDATE client SET adresse_client = :address, wilaya_client = :wilaya WHERE id_client = :id";
            $stmt = $conn->prepare($update_query);
            $stmt->bindParam(':address', $newAddress);
            $stmt->bindParam(':wilaya', $newWilaya);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            // Update session data
            $_SESSION['address'] = $newAddress;
            $_SESSION['wilaya'] = $newWilaya;

            // Success message
            $_SESSION['success_message'] = "Your address has been successfully updated.";

            // Redirect to the profile page
            header("Location: ../profil.php");
            exit();
        } catch (PDOException $e) {
            // Database error handling
            $_SESSION['address_error'] = "Error: " . $e->getMessage();

            // Redirect to the profile page with an error message
            header("Location: ../profil.php");
            exit();
        }
    } else {
        // Fields not filled
        $_SESSION['address_error'] = "Please fill in at least one field (Street or Wilaya).";

        // Redirect to the profile page with an error message
        header("Location: ../profil.php");
        exit();
    }
}
?>
