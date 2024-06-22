<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['recentPassword']) &&
        isset($_POST['newPassword']) &&
        isset($_POST['confirmNewPassword'])
    ) {
        $recentPassword = $_POST['recentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        // Check if fields are not empty
        if (empty($recentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
            $_SESSION['password_error'] = "Please fill in all fields.";
            header("Location: ../articles.php");
            exit();
        }

        // Check if new passwords match
        if ($newPassword !== $confirmNewPassword) {
            $_SESSION['password_error'] = "New passwords do not match.";
            header("Location: ../articles.php");
            exit();
        }

        // Check if the current password matches the one in the session
        // NOTE: You mentioned passwords are not hashed in the database.
        // It's important to directly compare the password with the one stored in the database.
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bddproject";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $admin_id = $_SESSION['admin_id']; // Get admin ID from session

            // Check current password in the database for the specified admin
            $checkPasswordQuery = "SELECT mot_de_passe_admin FROM admin WHERE id_admin = :admin_id";
            $stmt = $conn->prepare($checkPasswordQuery);
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->execute();
            $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($recentPassword !== $adminData['mot_de_passe_admin']) {
                $_SESSION['password_error'] = "Incorrect current password.";
                header("Location: ../articles.php");
                exit();
            }

            // Update password in the database for the specified admin
            $updatePasswordQuery = "UPDATE admin SET mot_de_passe_admin = :password WHERE id_admin = :admin_id";
            $stmt = $conn->prepare($updatePasswordQuery);
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->execute();

            // Success message
            $_SESSION['success_message_password'] = "Your password has been changed successfully.";

            // Redirect to articles page
            header("Location: ../articles.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['password_error'] = "Error: " . $e->getMessage();
            header("Location: ../articles.php");
            exit();
        }
    } else {
        $_SESSION['password_error'] = "Please fill in all fields.";
        header("Location: ../articles.php");
        exit();
    }
}
?>
