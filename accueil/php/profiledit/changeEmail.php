<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changeEmail'])) {
    // Vérification si l'email est renseigné
    if (isset($_POST['NewEmail'])) {
        // Paramètres de connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bddproject";

        try {
            // Connexion à la base de données avec PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Définir le mode d'erreur de PDO sur exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $newEmail = $_POST['NewEmail'];
            $userId = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur depuis la session

            // Validation du format de l'email
            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['email_error'] = "Invalid email format.";
                header("Location: ../profil.php");
                exit();
            }

            // Vérification si l'email existe déjà dans la table Client
            $emailCheckQuery = "SELECT email_client AS email FROM client WHERE email_client = :newEmail";
            $stmt = $conn->prepare($emailCheckQuery);
            $stmt->bindParam(':newEmail', $newEmail);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['email_error'] = "This email is already in use.";
                header("Location: ../profil.php");
                exit();
            } else {
                // Mise à jour de l'email dans la table Client
                $updateEmailQuery = "UPDATE client SET email_client = :newEmail WHERE id_client = :userId";
                $stmt = $conn->prepare($updateEmailQuery);
                $stmt->bindParam(':newEmail', $newEmail);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                $_SESSION['email'] = $newEmail; // Mettre à jour l'email dans la session
                $_SESSION['success_message_email'] = "Email successfully changed.";
                header("Location: ../profil.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['email_error'] = "Error updating email: " . $e->getMessage();
            header("Location: ../profil.php");
            exit();
        }
    }
}
?>
