<?php
session_start(); // Appel à session_start() au début du fichier pour démarrer la session

// ... Votre code HTML et PHP ici ...
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="../css/headeradmin.css">
    <link rel="stylesheet" href="../css/styleadmin.css">
    <link rel="stylesheet" href="../css/add_article.css">
    <link rel="stylesheet" href="../css/article.css">
    <script src="https://kit.fontawesome.com/c145710763.js" crossorigin="anonymous"></script>
    <style>
        /* Add your CSS styles here if needed */
    </style>
</head>

<body>
    <header>
        <h3>Modo Jewellery</h3>
        <div class="menu">
            <ul>
            <?php

// Vérification des messages d'erreur pour la suppression d'article
if (isset($_SESSION['error_message'])) {
    echo '<p style=" color: rgb(233, 72, 72);font-size:25px;">' . $_SESSION['error_message'] . '</p>';
    unset($_SESSION['error_message']); // Efface le message après l'avoir affiché
}

// Vérification des messages de succès pour la suppression d'article
if (isset($_SESSION['success_message'])) {
    echo '<p style="color: #32c069;font-size:25px;">' . $_SESSION['success_message'] . '</p>';
    unset($_SESSION['success_message']); // Efface le message après l'avoir affiché
}
?>
                <li class="ItemSearchBox">
            <form method="GET" action="rechercher.php">
                <!-- Modifier l'action pour pointer vers la page de recherche appropriée -->
                <input class="searchInputItemName" type="search" placeholder="Search for items" name="searchItemName">
                <button type="submit" name="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </li>




 <li><a href="form_add_article.php">Add Article</a></li>
                <li><a href="./editprofil/deconnexion.php?logout=1">Sign out</a></li>
            </ul>
        </div>
    </header>

    <div class="main">
        <div class="main_left">
            <a href="articles.php">Articles<i class="fa-solid fa-angle-right"></i></a>
            
            <a href="form_add_article.php">Add Article<i class="fa-solid fa-angle-right"></i></a>

            <a href="#" onclick="displayChangePasswordForm()">Change password <i class="fa-solid fa-angle-right"></i></a>
            <div id="changePasswordForm" style="display: none;">
                <form id="passwordForm" action="./editprofil/changepassword.php" method="POST">
                    <label for="recentPassword">Recent Password:</label><br>
                    <input type="password" id="recentPassword" name="recentPassword"><br>
                    <label for="newPassword">New Password:</label><br>
                    <input type="password" id="newPassword" name="newPassword"><br>
                    <label for="confirmNewPassword">Confirm New Password:</label><br>
                    <input type="password" id="confirmNewPassword" name="confirmNewPassword"><br><br>
                    <input type="submit" value="Change">
                </form>
            </div>
            <?php

               // Vérification des messages d'erreur
               if (isset($_SESSION['password_error'])) {
        echo '<p style="color: red;">' . $_SESSION['password_error'] . '</p>';
        unset($_SESSION['password_error']); // Efface le message après l'avoir affiché
               }

               // Vérification des messages de succès
                if (isset($_SESSION['success_message_password'])) {
        echo '<p style="color: green;">' . $_SESSION['success_message_password'] . '</p>';
        unset($_SESSION['success_message_password']); // Efface le message après l'avoir affiché
                 }
            ?>
            <a href="#" onclick="displayChangeEmailForm()">Change email<i class="fa-solid fa-angle-right"></i></a>

            <div id="changeEmailForm" style="display: none;">
                    <form id="emailForm" action="./editprofil/changeEmail.php" method="POST">
                    <label for="newEmail">New Email:</label><br>
                    <input type="email" id="newEmail" name="newEmail" class="password-field"><br><br>
                    <input type="submit" value="Change" class="password-submit" onclick="displayChangeEmailForm()">
                    </form>
            </div>
            <?php
               // Vérifier s'il y a un message d'erreur ou de succès à afficher
                if (isset($_SESSION['change_email_error'])) {
                echo '<p style="color:rgb(233, 72, 72); ">' . $_SESSION['change_email_error'] . '</p>';
                unset($_SESSION['change_email_error']); // Effacer le message d'erreur après l'avoir affiché
                }

            if (isset($_SESSION['change_email_success'])) {
                echo '<p style="color: #70db99;">' . $_SESSION['change_email_success'] . '</p>';
                unset($_SESSION['change_email_success']); // Effacer le message de succès après l'avoir affiché
                     }
                ?>

            <div class="Commande">
                <p>Commandes</p>
                <br>
                <input type="checkbox" name="commande"><p class="commande_detail">All</p> <br>
                <input type="checkbox" name="commande"><p class="commande_detail">Of today</p> <br>
                <input type="checkbox" name="commande"><p class="commande_detail"> Last week</p>
            </div>

        </div>
        <div class="main_right">
             <div class="main_right_top">
        <a href="articles.php">All</a>
        <a href="articles.php?category=Necklace">Necklace</a>
        <a href="articles.php?category=Bracelet">Bracelet</a>
        <a href="articles.php?category=Earring">Earring</a>
        <a href="articles.php?category=Ring">Ring</a>
        <a href="articles.php?category=Engagement">Engagement</a>
                    </div>

     <script src="../js/app.js"></script>
