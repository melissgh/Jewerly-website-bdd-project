<?php
function getAllArticles()
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
    $sql = "SELECT ID_article, Nom_article, Prix, Image_article, Quantite FROM article";
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






getAllArticles();
