<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si tous les champs sont remplis
    if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
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

            $email = $_POST['email'];
            $password = $_POST['mot_de_passe'];

            // Vérification si l'email existe dans la table Client
            $user_query = "SELECT id_client, mot_de_passe_client FROM client WHERE email_client = :email";
            $stmt = $conn->prepare($user_query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // L'email existe dans la table Client, vérification du mot de passe
                $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user_data['mot_de_passe_client'])) {
                    // Mot de passe correct, stockage de l'ID de l'utilisateur dans la session
                    $_SESSION['user_id'] = $user_data['id_client'];

                    // Redirection vers profil.php pour l'utilisateur
                    header("Location: profil.php");
                    exit();
                } else {
                    // Mot de passe incorrect pour l'utilisateur
                    $_SESSION['connexion_error'] = "Le mot de passe est incorrect.";
                    header("Location: home.php");
                    exit();
                }
            } else {
                // Vérification si l'email existe dans la table Admin
                $admin_query = "SELECT id_admin, mot_de_passe_admin FROM admin WHERE email_admin = :email";
                $stmt = $conn->prepare($admin_query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // L'email existe dans la table Admin, vérification du mot de passe pour l'administrateur
                    $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($password === $admin_data['mot_de_passe_admin']) {
                        // Mot de passe correct pour l'administrateur
                        // Stockage de l'ID de l'administrateur dans la session
                        $_SESSION['admin_id'] = $admin_data['id_admin'];

                        // Redirection vers articles.php pour l'admin
                        header("Location: ../../admin/php/articles.php");
                        exit();
                    } else {
                        // Mot de passe incorrect pour l'administrateur
                        $_SESSION['connexion_error'] = "Le mot de passe est incorrect pour l'administrateur.";
                        header("Location: home.php");
                        exit();
                    }
                } else {
                    // L'email n'existe pas dans les tables Client ou Admin
                    $_SESSION['connexion_error'] = "L'email n'existe pas.";
                    header("Location: home.php");
                    exit();
                }
            }
        } catch (PDOException $e) {
            // Erreur de connexion à la base de données
            $_SESSION['connexion_error'] = "Erreur de connexion à la base de données : " . $e->getMessage();
            header("Location: home.php");
            exit();
        }
    } else {
        // Champs non remplis
        $_SESSION['connexion_error'] = "Veuillez remplir tous les champs.";
        header("Location: header.php");
        exit();
    }
}
