<?php
session_start();

if (isset($_SESSION['user_id'])) {
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

        // Get the user ID to delete from the session
        $user_id = $_SESSION['user_id'];

        // Query to delete the user from the Users table
        $delete_query = "DELETE FROM client WHERE id_client= :user_id";
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Logout the user and redirect to the login page, for example
        session_destroy();
        header("Location:../home.php");
        exit();
    } catch (PDOException $e) {
        // If an error occurs while deleting the account
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle the case where the user is not logged in or doesn't have a user ID in the session
    echo "User not identified.";
}
?>
