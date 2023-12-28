<?php
include 'connexionDB.php';
include 'is_favoris.php';

function getAllArticlesByCategory($category)
{
    global $connexion;
    global $nom_base_de_donnee;
    $sql = "SELECT * FROM $nom_base_de_donnee.article AS a,$nom_base_de_donnee.categorie AS c WHERE c.nom_categorie = ? AND a.id_cat=c.id_categorie ";
    $req = $connexion->prepare($sql);
    $req->execute([$category]);

    $articles = $req->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des articles
    foreach ($articles as $article) {
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
        echo '            <a href=""><i class="fa-solid fa-cart-shopping"></i></a>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
}

// Exemple d'utilisation : pour afficher les articles d'une catégorie spécifique
//getAllArticlesByCategory("Rings"); // Remplace "Rings" par la catégorie voulue
