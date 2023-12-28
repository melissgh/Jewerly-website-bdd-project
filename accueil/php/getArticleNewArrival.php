<?php

function getAllArticlesNewArrival()
{
    // Connexion à la base de données (à adapter avec vos propres informations de connexion)
    $hostname = 'localhost'; // ou '127.0.0.1' ou l'adresse IP de votre serveur MySQL
    $dbname = 'bddproject';
    $username = 'root';
    $password = '';

    try {
        $dsn = "mysql:host=$hostname;dbname=$dbname";
        $dbh = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        exit();
    }

    // Requête SQL pour récupérer tous les articles avec leur ID
    $sql = "SELECT ID_article, Nom_article, Prix, Image_article, Quantite FROM article limit 5";
    $result = $dbh->query($sql);

    // Vérification des erreurs
    if (!$result) {
        die("Erreur lors de la récupération des articles: " . $dbh->errorInfo()[2]);
    }

    // Récupération des résultats et appel de la fonction afficherArticle() pour chaque article
    while ($article = $result->fetch(PDO::FETCH_ASSOC)) {
        // Ajouter une condition pour ne pas afficher si la quantité est égale à 0
        if ($article['Quantite'] > 0) {
            // Passer l'ID de l'article en paramètre à la fonction afficherArticle
            afficherArticle($article['ID_article'], $article);
        }
    }

    // Fermeture de la connexion à la base de données
    $dbh = null;
}
/* echo '<div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article_details.php?id=' . $articleId . '\')">'; */


/* function afficherArticle($articleId,$article) {
    echo '<div class="NewArrivalArticle shopArticles">';
    echo '  <div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article.php?id=' . $article['ID_article'] . '\')">';

    echo '    <img src="../../admin/php/uploads/' . $article['Image_article'] . '" alt="' . $article['Nom_article'] . '" data-tag="' . $article['Nom_article'] . '">';

    echo '        <button id="likebtn" class="likebtn"><i class="fa-regular fa-heart"></i></button>';
    echo '    </div>';
    echo '    <div class="NewArrivalArticleName">';
    echo '        <p>' . $article['Nom_article'] . '</p>';
    echo '        <div class="plusinfo">';
    echo '            <p>' . $article['Prix'] . 'DA</p>';
    echo '            <a href="#" class="articlebtnBag" data-id="' . $article['ID_article'] . '" data-id-client="' . $userId . '"><i class="fa-solid fa-cart-shopping"></i></a>';
    echo '        </div>';
    echo '    </div>';
    echo '</div>';
} */



getAllArticlesNewArrival();
