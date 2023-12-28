<?php

include '../model/is_favoris.php';
?>

<div id="new" class="NewArrival">
    <div class="NewArrivalTitle">
        <h3>New Arrival</h3>
        <a href="#"><button>See All <i class="fa-solid fa-angle-right"></i></button></a>
    </div>

    <div class="NewArrivalAetirles">

        <?php
        function afficherArticle($articleId, $article)
        {
            $userLoggedIn = isset($_SESSION['user_id']) ? true : false;

            // Définissez l'ID de l'utilisateur (s'il est connecté)
            $userId = $userLoggedIn ? $_SESSION['user_id'] : '';

            echo '<div class="NewArrivalArticle shopArticles">';
            echo '  <div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article.php?id=' . $article['ID_article'] . '\')">';

            echo '    <img src="../../admin/php/uploads/' . $article['Image_article'] . '" alt="' . $article['Nom_article'] . '" data-tag="' . $article['Nom_article'] . '">';

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
            echo '            <a href="#" class="articlebtnBag" data-id="' . $article['ID_article'] . '" data-id-client="' . $userId . '"><i class="fa-solid fa-cart-shopping"></i></a>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
        include('getArticleNewArrival.php');
        ?>

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

        <!-- <i class="fa-solid fa-heart"></i> -->



    </div>


    <div class="shopNow">
        <a href="Shop.php"><button>Shop Now</button></a>
    </div>
</div>
<script src="../js/panier.js"></script>