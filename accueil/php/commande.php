<?php

// Informations de connexion à la base de données
$host = 'localhost';
$dbname = 'bddproject';
$username = 'root';
$password = '';

// Récupérer les données du corps de la requête JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données nécessaires sont présentes
if (isset($data['userId']) && isset($data['articles']) && isset($data['clickDate'])) {
    $userId = $data['userId'];
    $articles = $data['articles'];
    $clickDate = $data['clickDate'];

    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Commencer une transaction
        $pdo->beginTransaction();

        // Vérifier si la date existe dans la table "dates"
        $stmtCheckDate = $pdo->prepare("SELECT id_date FROM dates WHERE id_date = :clickDate");
        $stmtCheckDate->bindParam(':clickDate', $clickDate);
        $stmtCheckDate->execute();
        $dateRow = $stmtCheckDate->fetch(PDO::FETCH_ASSOC);

        if (!$dateRow) {
            // La date n'existe pas, l'insérer dans la table "dates"
            $stmtInsertDate = $pdo->prepare("INSERT INTO dates (id_date) VALUES (:clickDate)");
            $stmtInsertDate->bindParam(':clickDate', $clickDate);
            $stmtInsertDate->execute();
        }

        // Boucle sur les articles et insère les données dans la table de commande
        foreach ($articles as $article) {
            $articleId = $article['articleId'];
            $quantity = $article['quantity'];

            $stmt = $pdo->prepare("INSERT INTO commande (id_client, id_article, id_date, quantite) VALUES (:userId, :articleId, :clickDate, :quantity)");
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':articleId', $articleId);
            $stmt->bindParam(':clickDate', $clickDate);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
        }

        // Valider la transaction
        $pdo->commit();

        // Fermer la connexion
        $pdo = null;

        // Envoyer une réponse JSON réussie au front-end
        $response = array('success' => true, 'message' => 'Order placed successfully');
        echo json_encode($response);
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        // $pdo->rollBack();

        // Gérer les erreurs de base de données
        $response = array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
        echo json_encode($response);
    }
} else {
    // Envoyer une réponse JSON indiquant des données manquantes au front-end
    $response = array('success' => false, 'message' => 'Missing data');
    echo json_encode($response);
}
