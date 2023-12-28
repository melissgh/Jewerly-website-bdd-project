<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['newPassword'])) {
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

            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];
            $userId = $_SESSION['user_id']; // Assuming you have a session variable for the user ID

            // Validate password length and match
            if (strlen($newPassword) < 8 || $newPassword !== $confirmNewPassword) {
                $_SESSION['password_error'] = "The password must be at least 8 characters long, and both password fields should match.";
                header("Location: ../profil.php");
                exit();
            }

            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the client table
            $updatePasswordQuery = "UPDATE client SET mot_de_passe_client = :hashedPassword WHERE id_client = :userId";
            $stmt = $conn->prepare($updatePasswordQuery);
            $stmt->bindParam(':hashedPassword', $hashedPassword);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $_SESSION['password'] = $hashedPassword; // Update the password in the session
            $_SESSION['success_message_password'] = "Password changed successfully.";
            header("Location: ../profil.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['password_error'] = "Error updating password: " . $e->getMessage();
            header("Location: ../profil.php");
            exit();
        }
    }
}
?>
