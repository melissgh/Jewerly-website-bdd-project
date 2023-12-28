<?php
include 'connexionDB.php';

if (!isset($_SESSION['user_id'])) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: header.php?login=true");
    exit();
} else if (!empty($_POST['id_article'])) {
    $idClient = $_SESSION['user_id'];

    $sql = "DELETE FROM $nom_base_de_donnee.favoris WHERE id_client = ? AND id_article = ?";
    $req = $connexion->prepare($sql);

    $req->execute(array(
        $idClient,
        $_POST['id_article'],
    ));

    if ($req->rowCount() != 0) {
        echo '<p style="text-align: center; color: red; font-size: 40px;">The favoris has been removed successfully.</p>';
        $_SESSION['success_message'] = "The favoris has been removed successfully.";
    } else {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: ../php/home.php");
    }
} else {
    $_SESSION['error_message'] = "Error removing the favoris.";
    header("Location: ../php/home.php");
    exit();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
