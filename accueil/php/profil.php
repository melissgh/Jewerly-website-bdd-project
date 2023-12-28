<?php include 'header.php';
include '../model/getFavoris.php';
include '../model/is_favoris.php'
?>
<div class="profilnavBar">
    <ul>
        <li><a href="#">My Profil</a></li>
        <li><a href="#">My Order</a></li>
        <li><a href="#">My Favorite</a></li>

        <!-- Ajout du code PHP pour afficher les messages -->
        <?php if (isset($_SESSION['success_message'])) : ?>
            <p class="success">Success: <?php echo $_SESSION['success_message']; ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['address_error'])) : ?>
            <p class="error">Error: <?php echo $_SESSION['address_error']; ?></p>
            <?php unset($_SESSION['address_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['phone_error'])) : ?>
            <p class="error">Error: <?php echo $_SESSION['phone_error']; ?></p>
            <?php unset($_SESSION['phone_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['firstname_error'])) : ?>
            <p class="error">Error: <?php echo $_SESSION['firstname_error']; ?></p>
            <?php unset($_SESSION['firstname_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['lastname_error'])) : ?>
            <p class="error">Error: <?php echo $_SESSION['lastname_error']; ?></p>
            <?php unset($_SESSION['lastname_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message_phone'])) : ?>
            <p class="success">Success: <?php echo $_SESSION['success_message_phone']; ?></p>
            <?php unset($_SESSION['success_message_phone']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message_firstname'])) : ?>
            <p class="success">Success: <?php echo $_SESSION['success_message_firstname']; ?></p>
            <?php unset($_SESSION['success_message_firstname']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message_lastname'])) : ?>
            <p class="success">Success: <?php echo $_SESSION['success_message_lastname']; ?></p>
            <?php unset($_SESSION['success_message_lastname']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message_email'])) : ?>
            <p class="success">Success: <?php echo $_SESSION['success_message_email']; ?></p>
            <?php unset($_SESSION['success_message_email']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['password_error'])) : ?>
            <p class="error">Error: <?php echo $_SESSION['password_error']; ?></p>
            <?php unset($_SESSION['password_error']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message_password'])) : ?>
            <p class="success">Success <?php echo $_SESSION['success_message_password']; ?></p>
            <?php unset($_SESSION['success_message_password']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['email_error'])) : ?>
            <p class="error">Error: <?php echo $_SESSION['email_error']; ?></p>
            <?php unset($_SESSION['email_error']); ?>
        <?php endif; ?>
    </ul>

    <ul>
        <li><a href="#" onclick="confirmDelete()" style="font-size: 20px;">Delete Account</a></li>
        <li>
            <a href="./profiledit/deconnexion.php?logout=1" style="font-size: 20px;">Log out</a>
            <i class="fas fa-sign-out-alt"></i>
        </li>
    </ul>
</div>

<hr class="lineProfil">

<div class="profilBox">
    <div class="profgauche">
        <h2>My Profile</h2>

        <?php
        // Vérifier si l'ID client est présent dans la session
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bddproject";

            try {
                // Connexion à la base de données avec PDO
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // Définir le mode d'erreur de PDO sur exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupérer les informations de l'utilisateur depuis la base de données
                $getUserInfoQuery = "SELECT nom_client, prenom_client, email_client, numero_de_telephone_client, adresse_client, wilaya_client FROM client WHERE id_client = :userId";
                $stmt = $conn->prepare($getUserInfoQuery);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);

                // Stocker les informations récupérées dans la session
                $_SESSION['nom'] = $userData['nom_client'];
                $_SESSION['prenom'] = $userData['prenom_client'];
                $_SESSION['email'] = $userData['email_client'];
                $_SESSION['phone'] = $userData['numero_de_telephone_client'];
                $_SESSION['address'] = $userData['adresse_client'];
                $_SESSION['wilaya'] = $userData['wilaya_client'];

                // Afficher les informations de profil
                echo '<h3>User Name</h3>';
                echo '<p>' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</p>';
                echo '<h3>Email</h3>';
                echo '<p>' . $_SESSION['email'] . '</p>';
                echo '<h3>Address</h3>';
                echo '<p>' . $_SESSION['address'] . ', ' . $_SESSION['wilaya'] . '</p>';
                echo '<h3>Phone </h3>';
                echo '<p>' . $_SESSION['phone'] . '</p>';
            } catch (PDOException $e) {
                // Gérer les erreurs de connexion à la base de données
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            // Si l'ID client n'est pas présent dans la session
            echo "ID client non trouvé dans la session.";
        }
        ?>
    </div>

    <div class="profildroit">

        <div id="changePasswordForm">
            <h2>Change Password </h2>
            <br>
            <form id="passwordForm" action="profiledit/changepassword.php" method="POST">
                <label for="recentPassword">Recent Password:</label><br>
                <input type="password" id="recentPassword" name="recentPassword"><br>
                <label for="newPassword">New Password:</label><br>
                <input type="password" id="newPassword" name="newPassword"><br>
                <label for="confirmNewPassword">Confirm New Password:</label><br>
                <input type="password" id="confirmNewPassword" name="confirmNewPassword"><br>
                <button id="saveChanges">Change </button>

            </form>
        </div>
        <div>
            <div id="changeFirstForm">
                <h2> Change FirstName </h2>
                <br>
                <form id="UserFirstForm" action="profiledit/changeFirstname.php" method="POST">
                    <label for="NewFirstName">First name</label><br>
                    <input type="text" id="NewFirstName" name="NewFirstName"><br>

                    <button id="saveChanges">Change </button>
                </form>
            </div>
            <div id="changeLastForm">
                <h2> Change Last Name </h2>
                <br>
                <form id="UsernameForm" action="profiledit/changeLastname.php" method="POST">

                    <label for="NewLastName">Last name</label><br>
                    <input type="text" id="NewLastName" name="NewLastName"><br>
                    <button id="saveChanges">Change </button>

                </form>
            </div>
        </div>
        <div>
            <div id="changeEmailForm">
                <h2> Change Email </h2>
                <br>
                <form id="EmailForm" action="profiledit/changeEmail.php" method="POST">
                    <label for="New_Email">New Email</label><br>
                    <input type="email" id="New_Email" name="NewEmail"><br>
                    <button id="saveChanges" name="changeEmail">Change</button>
                </form>
            </div>


            <div id="changePhoneForm">
                <h2> Change Phone Number </h2>
                <br>
                <form id="PhoneForm" action="profiledit/changePhoneNumber.php" method="POST">
                    <label for="NewPhoneNumber">Phone Number</label><br>
                    <input type="text" id="NewPhoneNumber" name="NewPhoneNumber"><br>
                    <button id="saveChanges" name="changePhone">Change</button>
                </form>
            </div>
        </div>
        <div id="changeAddressForm">
            <h2> Change Address </h2>
            <br>
            <form id="AddressForm" action="./profiledit/changeAddress.php" method="POST">
                <label for="NewStreatAddress">New Street Address</label>
                <input type="text" name="address"><br>
                <label for="NewWilaya">Wilaya</label>
                <select name="wilaya" id="wilaya" style="color: #999;">
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

                <button id="saveChanges">Change</button>

            </form>
            <br> <br>

        </div>


    </div>

</div>

<hr class="lineFavorite">

<div class="favoriteBox">
    <h2>Favorite</h2>
</div>

<!-- afficher favoris du client -->

<div class="NewArrivalAetirles">
    <?php
    $toutfavoris = getFavorisByClientId($_SESSION['user_id']);

    if ($toutfavoris) {
        foreach ($toutfavoris as $favoris) {
            $isFavori = isFavori($favoris['ID_article']);

            echo '<div class="NewArrivalArticle shopArticles">';
            echo '  <div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article.php?id=' . $favoris['ID_article'] . '\')">';

            echo '    <img src="../../admin/php/uploads/' . $favoris['Image_article'] . '" alt="' . $favoris['Nom_article'] . '" data-tag="' . $favoris['Nom_article'] . '">';

            if ($isFavori) {
                echo '<form method="POST" action="../model/supprimerFavoris.php">';
                echo '<input type="hidden" name="id_article" value="' . $favoris['ID_article'] . '">';
                echo '<button type="submit" class="likebtn liked"><i class="fa-solid fa-heart"></i></button>';
                echo '</form>';
            } else {
                echo '<form method="POST" action="../model/ajouterFavori.php">';
                echo '<input type="hidden" name="id_article" value="' . $favoris['ID_article'] . '">';
                echo '<button type="submit" class="likebtn"><i class="fa-regular fa-heart"></i></button>';
                echo '</form>';
            }

            echo '    </div>';
            echo '    <div class="NewArrivalArticleName">';
            echo '        <p>' . $favoris['Nom_article'] . '</p>';
            echo '        <div class="plusinfo">';
            echo '            <p>' . $favoris['Prix'] . 'DA</p>';
            echo '            <a href=""><i class="fa-solid fa-cart-shopping"></i></a>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    }
    ?>
</div>

<hr class="lineOrder">

<div class="OrderBox">
    <h2>My Order</h2>
</div>

<script>
    function confirmDelete() {
        var result = confirm("Are you sure you want to delete your account?");
        if (result) {
            window.location.href = "./profiledit/delete_account.php"; // Rediriger vers le script de suppression si l'utilisateur confirme
        }
    }
</script>
<script src="../js/panier.js"></script>

<?php include 'footer.php'; ?>