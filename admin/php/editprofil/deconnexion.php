<?php
session_start();

// Vérifier si le paramètre logout est présent dans l'URL
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Détruire toutes les données de session
    session_destroy();
    // Rediriger vers la page d'accueil
    header("Location: ../../../accueil/php/home.php");
    exit();
}
?>
