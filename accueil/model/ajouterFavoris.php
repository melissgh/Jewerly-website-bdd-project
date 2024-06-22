<?php
include 'connexionDB.php';
if (!isset($_SESSION['user_id'])) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: ../php/header.php?login=true"); // Redirection vers la page de connexion avec le paramètre login=true
    exit(); // Arrêtez le script après la redirection
} else if (!empty($_POST['id_article'])) {
    $idClient = $_SESSION['user_id'];

    $sql = "INSERT INTO $nom_base_de_donnee.favoris (id_client, id_article) VALUES (?, ?)";

    $req = $connexion->prepare($sql);

    $req->execute(array(
        $idClient,
        $_POST['id_article'],
    ));

    if ($req->rowCount() != 0) {
        echo '<p style="text-align: center; color: red; font-size: 40px;">The article has been added successfully on your favoris.</p>';
        $_SESSION['success_message'] = "The article has been added successfully on your favoris.";
    } else {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: ../php/home.php");
    }
} else {
    $_SESSION['error_message'] = "Error adding the favoris.";
    header("Location: ../php/home.php");
    exit();
}

// header("Location: ../php/home.php");
header("Location: " . $_SERVER['HTTP_REFERER']);
