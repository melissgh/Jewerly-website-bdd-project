<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jewelry</title>
    <!-- Styles -->
    <link rel="stylesheet" href="../css/Style.css">
    <link rel="stylesheet" href="../css/item.css">
    <link rel="stylesheet" href="../css/form.css">

    <link rel="stylesheet" href="../css/newarrivals.css">
    <link rel="stylesheet" href="../css/shop.css">
    <link rel="stylesheet" href="../css/profil.css">
    <link rel="stylesheet" href="../css/panier.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/favoris.css">

    <!-- Fonts and Icons -->
    <script src="https://kit.fontawesome.com/996095cfc6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="home">
        <!-- Navigation -->
        <div class="navBar">
            <!-- Navbar Links -->
            <ul class="list1">
                <li><a href="home.php">Home</a></li>
                <li><a href="home.php#contact">Contact</a></li>
                <li><a href="home.php#about">About Us</a></li>
                <li><a href="#">Category</a></li>
            </ul>
            <!-- User Icons -->
            <ul class="list2">
                <!-- Icon based on User LoggedIn Status -->
                <?php


                $userLoggedIn = isset($_SESSION['user_id']) ? true : false;
                if ($userLoggedIn) {
                    echo '<li><a href="profil.php"><i class="fa-regular fa-user"></i></a></li>';
                } else {
                    echo '<li><a href="#" id="userIcon"><i class="fa-regular fa-user"></i></a></li>';
                }

                ?>
                <!-- Other Icons -->
                <li><a href="favoris.php"><i class="fa-regular fa-heart"></i></a></li>
                <li class="cart"><a href="./panier.php"><i class="fa-solid fa-cart-plus"></i><span>0</span></a></li>
            </ul>
        </div>

        <!-- Login Form -->
        <div class="formcontainer" id="loginForm" style="display: <?php echo isset($_GET['login']) ? 'block' : 'none'; ?>;">
            <!-- le code permet de vérifier si le paramètre login est présent dans l'URL. Si c'est le cas, la section de connexion (#loginForm) sera affichée (style="display: block;"), sinon elle restera cachée (style="display: none;"). -->
            <!-- <div class="formcontainer" id="loginForm" style="display:none;"> -->
            <div class="title">Login</div>
            <!-- PHP Error Message Handling -->
            <?php

            if (isset($_SESSION['connexion_error']) && !empty($_SESSION['connexion_error'])) {
                echo '<div class="error-message">' . $_SESSION['connexion_error'] . '</div>';
                unset($_SESSION['connexion_error']); // Effacer les erreurs de la session après affichage
            }

            ?>
            <!-- Form Elements -->
            <span class="close-icon">&#10006;</span>
            <div class="formcontent">
                <form action="connexion.php" method="post">
                    <!-- Input Fields -->
                    <div class="user-details">
                        <!-- Email and Password Input Fields -->
                        <div class="input-box" style="width:100%;">
                            <span class="details">Email</span>
                            <input type="text" placeholder="Enter your email" required name="email">
                        </div>
                        <div class="input-box">
                            <span class="details">Password</span>
                            <input type="password" placeholder="Enter your password" required name="mot_de_passe">
                        </div>
                    </div>
                    <!-- Login Button and Link -->
                    <div class="button">
                        <input type="submit" value="Log in">
                        <br>
                        <a href="#inscriptionForm" class="login-link">Don't have an account? Sign up</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="formcontainer" id="inscriptionForm" style="display: <?php echo isset($_SESSION['inscription_error']) ? 'block' : 'none'; ?>;">
            <div class="title">Register</div>
            <!-- PHP Error Message Handling -->
            <?php
            // Appel à session_start() au début du fichier pour démarrer la session
            if (isset($_SESSION['inscription_error']) && !empty($_SESSION['inscription_error'])) {
                echo '<div class="error-message">' . $_SESSION['inscription_error'] . '</div>';
                unset($_SESSION['inscription_error']); // Effacer les erreurs de la session après affichage
            }

            ?>
            <!-- Form Elements -->
            <span class="close-icon">&#10006;</span>
            <div class="formcontent">
                <form action="inscription.php" method="post">
                    <div class="user-details">
                        <div class="input-box">
                            <input type="text" required name="nom" placeholder="Last name">
                        </div>
                        <div class="input-box">
                            <input type="text" required name="prenom" placeholder="First name">
                        </div>
                        <div class="input-box">
                            <input type="text" required name="email" placeholder="Email">
                        </div>
                        <div class="input-box">
                            <input type="number" required name="phone" placeholder="Phone Number">
                        </div>
                        <div class="input-box">
                            <input type="password" required name="mot_de_passe" placeholder="Password">
                        </div>
                        <div class="input-box">
                            <input type="password" required name="confpsw" placeholder="Confirm Password">
                        </div>

                        <div class="input-box">
                            <select name="wilaya" id="wilaya" style="color: #999;">
                                <option value="" disabled selected style="color: #999;">Select your wilaya</option>
                                <optgroup>
                                    <!-- Ajoutez ici les options pour les wilayas -->
                                    <option value="Alger">Alger</option>
                                    <option value="Oran">Oran</option>
                                    <option value="Constantine">Constantine</option>
                                    <option value="Béjaïa">Béjaïa</option>
                                    <option value="Tizi Ouzou">Tizi Ouzou</option>
                                    <option value="Béjaïa">Annaba</option>
                                    <option value="Béjaïa">Tlemcen</option>
                                    <!-- Assurez-vous d'avoir un total de 20 options pour les wilayas -->
                                </optgroup>
                            </select>
                        </div>


                        <div class="input-box">
                            <input type="text" required name="address" placeholder="Street Adress">
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" value="Register">
                        <br>
                        <a href="#loginForm" class="login-link">Already have an account? Log in</a>
                    </div>
                </form>

            </div>
        </div>


        <!-- JavaScript -->
        <script src="../js/form.js"></script>