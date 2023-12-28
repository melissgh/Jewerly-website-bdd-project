<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['article_id'])) {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddproject";

    try {
        // Connect to the database using PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $article_id = $_GET['article_id'];

        // Deletion from the "conception" relationship table
        $stmt = $conn->prepare("DELETE FROM conception WHERE id_article = :article_id");
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();

        // Delete from other relationship tables if necessary (order, comment, favorites)

        // Deletion from the "article" table
        $stmt = $conn->prepare("DELETE FROM article WHERE ID_article = :article_id");
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();

        $_SESSION['success_message'] = "The article has been deleted successfully.";
        header("Location: articles.php"); // Redirect to the article list after deletion
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error deleting the article: " . $e->getMessage();
        header("Location: articles.php"); // Redirect to the article list with an error message
        exit();
    }
} else {
    $_SESSION['error_message'] = "Error deleting the article. Please provide a valid article ID.";
    header("Location: articles.php"); // Redirect to the article list with an error message
    exit();
}
?>
