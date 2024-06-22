<?php include 'header.php';
include '../model/getFavoris.php';
include '../model/is_favoris.php'
?>
<hr class="lineFavorite">

<div class="favoriteBox">
    <h2>Favorite</h2>

    <div class="allFavoriteBox">
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
</div>

<script src="../js/panier.js"></script>
<?php include 'footer.php'; ?>