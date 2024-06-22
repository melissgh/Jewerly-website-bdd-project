<?php include 'header.php';
include '../model/is_favoris.php';

$userLoggedIn = isset($_SESSION['user_id']) ? true : false;

// Définissez l'ID de l'utilisateur (s'il est connecté)
$userId = $userLoggedIn ? $_SESSION['user_id'] : '';

?>
<div class="shopage">
    <!-- <div class="shopLeft">
                <h3>Shop</h3>
                <ul>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Best Sallers</a></li>
                    <li><a href="#">Shop All </a></li>
                    <li><a href="#">Necklaces</a></li>
                    <li><a href="#">Rings</a></li>
                    <li><a href="#">Earrings</a></li>
                    <li><a href="#">Bracelets</a></li>
                    <li><a href="#">Wedding</a></li>
                    <li><a href="#">Men's</a></li>
                    <li><a href="#">kids</a></li>
                </ul>
            </div>  -->


    <div class="shopRigth">
        <div class="shopRigthTop">
            <div class="shopRigthTopTop">
                <h2>Shop</h2>
            </div>
            <div class="shopRigthTopTopButtom">
                <button class="filterButton">ALL FILTERS + SORT</button>
                <ul>
                    <li><a href="./home.php#new">New Arrivals</a></li>
                    <li><a href="./Shop.php">Shop All</a></li>
                    <li><a href="Necklace.php">Necklaces</a></li>
                    <li><a href="rings.php">Rings</a></li>
                    <li><a href="earring.php">Earrings</a></li>
                    <li><a href="bracelet.php">Bracelets</a></li>
                    <li><a href="engagement.php">Engagement</a></li>
                    <li class="ItemSearchBox">
                        <form method="POST" action="./rechercheshop.php">
                            <input class="searchInputItemName" type="search" placeholder="Srearch for items" name="serachitemName">
                            <button type="submit" name="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="shopRigthbuttom">




            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bddproject";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Get the category from the URL (GET parameter)
                $category = isset($_GET['category']) ? $_GET['category'] : null;

                if ($category && $category !== 'All') {
                    // Build the SQL query to retrieve articles based on the selected category
                    $stmt = $conn->prepare("SELECT a.ID_article, a.Nom_article, a.Image_article, a.Description_article, a.Quantite, a.Prix, c.Nom_categorie 
                                FROM article a
                                JOIN categorie c ON a.id_cat = c.id_categorie
                                WHERE c.nom_categorie = :category AND a.Quantite > 0");
                    $stmt->bindParam(':category', $category);
                    $stmt->execute();
                    $articles = $stmt->fetchAll();

                    // Display articles corresponding to the selected category
                    foreach ($articles as $article) {
                        // Check if quantity is greater than 0 before displaying the article
                        if ($article['Quantite'] > 0) {
                            echo '<div class="NewArrivalArticle shopArticles">';
                            echo '  <div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article.php?id=' . $article['ID_article'] . '\')">';
                            #echo '<p>' . $article['ID_article'] . '</p>';
                            #echo '<p>' . $userId . '</p>';
                            echo '    <img src="../../admin/php/uploads/' . $article['Image_article'] . '" alt="' . $article['Nom_article'] . '" data-tag="' . $article['Image_article'] . '" data-img="' . $article['Image_article'] . '"   >';

                            echo '        <button id="likebtn" class="likebtn"><i class="fa-regular fa-heart"></i></button>';
                            echo '    </div>';
                            echo '    <div class="NewArrivalArticleName">';
                            echo '        <p>' . $article['Nom_article'] . '</p>';
                            echo '        <div class="plusinfo">';
                            echo '            <p>' . $article['Prix'] . 'DA</p>';
                            echo '            <a href="#" class="articlebtnBag" data-id="' . $article['ID_article'] . '" data-id-client="' . $userId . '"><i class="fa-solid fa-cart-shopping"></i></a>
            ';
                            echo '        </div>';
                            echo '    </div>';
                            echo '</div>';
                        }
                    }

                    // If no articles found in the selected category
                    if (count($articles) === 0) {
                        echo '<p style="text-align: center; color: red; font-size: 40px;">No available articles in this category.</p>';
                    }
                } else {
                    // No category selected, include getArticleShop.php
                    function afficherArticle($articleId, $article)
                    {

                        $userLoggedIn = isset($_SESSION['user_id']) ? true : false;
                        $userId = $userLoggedIn ? $_SESSION['user_id'] : '';

                        echo '<div class="NewArrivalArticle shopArticles">';
                        echo '  <div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article.php?id=' . $article['ID_article'] . '\')">';
                        #echo '<p>' . $article['ID_article'] . '</p>';
                        #echo '<p>' . $userId . '</p>';
                        echo '    <img src="../../admin/php/uploads/' . $article['Image_article'] . '" alt="' . $article['Nom_article'] . '" data-tag="' . $article['Image_article'] . '" data-img="' . $article['Image_article'] . '"   >';

                        $isFavori = isFavori($article['ID_article']);
                        if ($isFavori) {
                            echo '<form method="POST" action="../model/supprimerFavoris.php">';
                            echo '<input type="hidden" name="id_article" value="' . $article['ID_article'] . '">';
                            echo '<button type="submit" class="likebtn liked"><i class="fa-solid fa-heart"></i></button>';
                            echo '</form>';
                        } else {
                            echo '<form method="POST" action="../model/ajouterFavoris.php">';
                            echo '<input type="hidden" name="id_article" value="' . $article['ID_article'] . '">';
                            echo '<button type="submit" class="likebtn"><i class="fa-regular fa-heart"></i></button>';
                            echo '</form>';
                        }
                        echo '    </div>';
                        echo '    <div class="NewArrivalArticleName">';
                        echo '        <p>' . $article['Nom_article'] . '</p>';
                        echo '        <div class="plusinfo">';
                        echo '            <p>' . $article['Prix'] . 'DA</p>';
                        echo '            <a href="#" class="articlebtnBag" data-id="' . $article['ID_article'] . '" data-id-client="' . $userId . '"><i class="fa-solid fa-cart-shopping"></i></a>
            ';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                    include('getArticleShop.php');
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            #include ('getArticleShop.php');
            ?>

            <!-- <div>
                        onclick="redirectToItemPage()"
                    </div> -->


            <!-- <div class="NewArrivalArticle shopArticles" >
                        <div class="NewArrivalArticleImg" onclick="redirectToItemPage('article.php')">
                            
                            <img src="../pic/earringImgPexlp.jpeg" alt="kgfdfg" data-tag="earringPexlp">
                            <button id="likebtn" class="likebtn"><i class="fa-regular fa-heart"></i></button>
                        </div>
                        <div class="NewArrivalArticleName">
                            <p>Collier Collier</p>
                            <div class="plusinfo">
                                <p>100.00$</p>
                                
                                <a href=""><i class="fa-solid fa-cart-shopping"></i></a>
                                
                            </div>
                        </div>
                    </div> -->







        </div>
    </div>
</div>






<script src="../js/app.js"></script>
<script src="../js/panier.js"></script>

<?php include 'footer.php' ?>