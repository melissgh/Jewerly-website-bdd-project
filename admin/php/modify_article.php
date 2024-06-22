<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $article_id = $_POST['article_id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $materials = $_POST['materials'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $article_description = $_POST['article_description'];
    $material_description = $_POST['material_description'];

    if (empty($name) || empty($category) || empty($materials) || empty($article_description) || empty($material_description)) {
        $_SESSION['error_message'] = "All fields except the image are mandatory.";
        header("Location: form_modify_article.php?article_id=$article_id");
        exit();
    }

    if ($quantity <= 0) {
        $_SESSION['error_message'] = "Quantity must be greater than zero.";
        header("Location: form_modify_article.php?article_id=$article_id");
        exit();
    }

    if ($price <= 0) {
        $_SESSION['error_message'] = "Price must be greater than zero.";
        header("Location: form_modify_article.php?article_id=$article_id");
        exit();
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddproject";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $category_id = null;
        if (!empty($category)) {
            $stmt = $conn->prepare("SELECT id_categorie FROM categorie WHERE nom_categorie = :category");
            $stmt->bindParam(':category', $category);
            $stmt->execute();
            $category_id = $stmt->fetchColumn();
        }

        $update_article_query = "UPDATE article SET Nom_article = :name, Description_article = :article_description, Quantite = :quantity, Prix = :price, description_materiel = :material_description";
        if ($category_id !== null) {
            $update_article_query .= ", id_cat = :category_id";
        }
        if (!empty($_FILES['image']['name'])) {
            $update_article_query .= ", image_article = :image";
        }
        $update_article_query .= " WHERE ID_article = :article_id";

        $stmt = $conn->prepare($update_article_query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':article_description', $article_description);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':material_description', $material_description);
        if ($category_id !== null) {
            $stmt->bindParam(':category_id', $category_id);
        }
        $stmt->bindParam(':article_id', $article_id);

        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            $stmt->bindParam(':image', $image);
        }

        $stmt->execute();

        if (!empty($materials)) {
            $delete_materials_query = "DELETE FROM conception WHERE id_article = :article_id";
            $stmt = $conn->prepare($delete_materials_query);
            $stmt->bindParam(':article_id', $article_id);
            $stmt->execute();

            foreach ($materials as $material) {
                $stmt = $conn->prepare("SELECT id_materiel FROM materiel WHERE nom_materiel = :material");
                $stmt->bindParam(':material', $material);
                $stmt->execute();
                $material_id = $stmt->fetchColumn();

                $insert_conception_query = "INSERT INTO conception (id_article, id_materiel) VALUES (:article_id, :material_id)";
                $stmt = $conn->prepare($insert_conception_query);
                $stmt->bindParam(':article_id', $article_id);
                $stmt->bindParam(':material_id', $material_id);
                $stmt->execute();
            }
        }

        $_SESSION['success_message'] = "The article has been modified successfully.";
        header("Location: articles.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: form_modify_article.php?article_id=$article_id");
        exit();
    }
}
?>
