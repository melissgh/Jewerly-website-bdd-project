<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Récupération des valeurs du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["mot_de_passe"];
        $confpsw = $_POST["confpsw"];
        $wilaya = $_POST["wilaya"];
        $address = $_POST["address"];

        // Validation des champs
        $errors = [];

        if (empty($nom) || empty($prenom) || empty($email) || empty($phone) || empty($password) || empty($confpsw) || empty($wilaya) || empty($address)) {
            $errors[] = "Tous les champs sont requis.";
        }

        if (strlen($nom) < 3 || strlen($prenom) < 3) {
            $errors[] = "Le nom et le prénom doivent comporter au moins quatre caractères.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "La syntaxe de l'email est incorrecte.";
        }

        if (!preg_match("/^(05|06|07)[0-9]{8}$/", $phone)) {
            $errors[] = "Le numéro de téléphone doit commencer par 05, 06 ou 07 et comporter 10 chiffres.";
        }

        if (strlen($password) < 8 || $password != $confpsw) {
            $errors[] = "Le mot de passe doit comporter au moins huit caractères et les deux champs de mot de passe doivent correspondre.";
        }

        $sql = "SELECT email_client FROM client WHERE email_client = :email UNION SELECT email_admin FROM admin WHERE email_admin = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors[] = "Cet email existe déjà.";
        }

        // Si aucune erreur n'est détectée, insérer les données dans la table Client
        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO client (nom_client, prenom_client, email_client, numero_de_telephone_client, mot_de_passe_client, wilaya_client, adresse_client) VALUES (:nom, :prenom, :email, :phone, :hashed_password, :wilaya, :address)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':hashed_password', $hashed_password);
            $stmt->bindParam(':wilaya', $wilaya);
            $stmt->bindParam(':address', $address);
            $stmt->execute();

            // Stockage uniquement de l'ID de l'utilisateur dans la session après l'inscription réussie
            $_SESSION['user_id'] = $conn->lastInsertId(); // Récupère l'ID de l'utilisateur nouvellement inscrit

            header("Location: profil.php"); // Redirection vers la page profil.php après l'inscription réussie
            exit();
        } else {
            $_SESSION['inscription_error'] = implode("<br>", $errors);
            header("Location: home.php"); // Redirection vers le formulaire d'inscription avec les messages d'erreur
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['inscription_error'] = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        header("Location: home.php");
        exit();
    }
}
?>
