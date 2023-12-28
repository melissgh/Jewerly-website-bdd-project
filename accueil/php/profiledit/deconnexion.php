<?php
session_start();

// Vérifier si le lien de déconnexion est cliqué
if (isset($_GET['logout'])) {
    // Détruire toutes les données de session
    session_destroy();
    // Rediriger vers la page de connexion ou autre page de votre choix
    header("Location: ../home.php"); // Remplacez 'home.php' par la page souhaitée
    exit();
}
?>
