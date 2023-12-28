<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['email']) && isset($_POST['newEmail'])) {
        $newEmail = $_POST['newEmail'];

        // Check email syntax
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['change_email_error'] = "The entered email is not valid.";
            header("Location: ../articles.php");
            exit();
        }

        // Check if the new email is the same as the old one
        if ($_SESSION['email'] === $newEmail) {
            $_SESSION['change_email_error'] = "You just entered the same email as the previous one.";
            header("Location: ../articles.php");
            exit();
        }

        // Check if the new email exists in the Users table
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bddproject";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $userQuery = "SELECT * FROM client WHERE email_client = :newEmail";
            $stmt = $conn->prepare($userQuery);
            $stmt->bindParam(':newEmail', $newEmail);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Email exists in the Users table, send an error
                $_SESSION['change_email_error'] = "The email is already in use.";
                header("Location: ../articles.php");
                exit();
            } else {
                // Update the email in the Admin table
                $adminId = $_SESSION['admin_id'];
                $updateQuery = "UPDATE Admin SET email_admin = :newEmail WHERE id_admin = :adminId";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bindParam(':newEmail', $newEmail);
                $stmt->bindParam(':adminId', $adminId);
                $stmt->execute();

                $_SESSION['email'] = $newEmail; // Update the email in the session

                $_SESSION['change_email_success'] = "The email has been changed successfully.";
                header("Location: ../articles.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['change_email_error'] = "Error: " . $e->getMessage();
            header("Location: ../articles.php");
            exit();
        }
    } else {
        $_SESSION['change_email_error'] = "An error occurred. Please try again.";
        header("Location: ../articles.php");
        exit();
    }
} else {
    $_SESSION['change_email_error'] = "Unauthorized method.";
    header("Location: ../articles.php");
    exit();
}
?>
