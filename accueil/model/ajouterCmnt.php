<?php
include 'connexionDB.php';
if (!isset($_SESSION['user_id'])) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: ../php/header.php?login=true"); // Redirection vers la page de connexion avec le paramètre login=true
    exit(); // Arrêtez le script après la redirection
} else if (!empty($_POST['contenu'])) {
    $idClient = $_SESSION['user_id'];
    // $date = date("Y-m-d"); // Format de date pour une colonne de type DATE en MySQL

    // $sql = "INSERT INTO $nom_base_de_donnee.commentaire (id_client, id_article, date_commentaire, contenu) VALUES (?, ?, ?, ?)";

    // $req = $connexion->prepare($sql);

    // $req->execute(array(
    //     $idClient,
    //     $_POST['id_article'],
    //     $date, // Utilisation de la date formatée
    //     $_POST['contenu']
    // ));
    // Insertion de la date dans la table Dates

    $id_date = date("Y-m-d H:i:s");

    // Insérer la date dans la table Dates
    $sql0 = "INSERT INTO $nom_base_de_donnee.Dates (id_date) VALUES (?)";
    $req0 = $connexion->prepare($sql0);
    $req0->execute([$id_date]);

    // Insertion du commentaire dans la table commentaire 
    $sql = "INSERT INTO $nom_base_de_donnee.commentaire (id_client, id_article, id_date, contenu) VALUES (?, ?, ?, ?)";
    $req = $connexion->prepare($sql);
    $req->execute([$idClient, $_POST['id_article'], $id_date, $_POST['contenu']]);

    if ($req->rowCount() != 0) {
        echo '<p style="text-align: center; color: red; font-size: 40px;">The review has been added successfully.</p>';
        $_SESSION['success_message'] = "The review has been added successfully.";
    } else {
        header("Location: article.php?id=" . $_POST['id_article']);
        exit();
    }
} else {
    $_SESSION['error_message'] = "Error adding the review.";
    header("Location: article.php?id=" . $_POST['id_article']);
    exit();
}

header("Location: ../php/article.php?id=" . $_POST['id_article']);
