<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    if (isset($_POST['name']) && isset($_POST['category']) && isset($_POST['materials']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['article_description']) && isset($_FILES['image'])) {
        // Check if the image is uploaded without errors
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
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

                // Get form data
                $name = $_POST['name'];
                $category = $_POST['category'];
                $materials = $_POST['materials'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $article_description = $_POST['article_description'];
                $material_description = $_POST['material_description'];
                $admin_id = 1; // Admin ID to insert (you specified 1)

                // Check quantity and price
                if ($quantity <= 0) {
                    $_SESSION['error_message'] = "The quantity must be greater than zero.";
                    header("Location: form_add_article.php"); // Redirect to the form with an error message
                    exit();
                }
                if ($price <= 0) {
                    $_SESSION['error_message'] = "The price must be greater than zero.";
                    header("Location: form_add_article.php"); // Redirect to the form with an error message
                    exit();
                }
                // Get the ID of the selected category
                $stmt = $conn->prepare("SELECT id_categorie FROM categorie WHERE nom_categorie = :category");
                $stmt->bindParam(':category', $category);
                $stmt->execute();
                $category_id = $stmt->fetchColumn();

                // Check if the article name already exists in the database
                $check_article_query = "SELECT COUNT(*) FROM article WHERE Nom_article = :name";
                $stmt = $conn->prepare($check_article_query);
                $stmt->bindParam(':name', $name);
                $stmt->execute();
                $article_exists = $stmt->fetchColumn();

                if ($article_exists) {
                    $_SESSION['error_message'] = "An article with this name already exists.";
                    header("Location: form_add_article.php"); // Redirect to the form with an error message
                    exit();
                }

                // Image processing
                $image_path = "uploads/"; // Directory where the image will be stored (adapt as per your structure)
                $image_name = $_FILES['image']['name'];
                $image_tmp = $_FILES['image']['tmp_name'];
                move_uploaded_file($image_tmp, $image_path . $image_name);

                // Insert data into the article table
                $insert_article_query = "INSERT INTO article (Nom_article, Image_article, Description_article, Quantite, Prix, id_cat, id_adm, description_materiel) VALUES (:name, :image, :article_description, :quantity, :price, :category_id, :admin_id, :material_description)";
                $stmt = $conn->prepare($insert_article_query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':image', $image_name);
                $stmt->bindParam(':article_description', $article_description);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':admin_id', $admin_id);
                $stmt->bindParam(':material_description', $material_description);
                // Add description to the newly added column
                $stmt->execute();

                // Get the ID of the inserted article
                $last_article_id = $conn->lastInsertId();

                // Get material IDs from the database
                foreach ($materials as $material) {
                    $stmt = $conn->prepare("SELECT id_materiel FROM materiel WHERE nom_materiel = :material");
                    $stmt->bindParam(':material', $material);
                    $stmt->execute();
                    $material_id = $stmt->fetchColumn();

                    // Insert data into the conception table
                    $insert_conception_query = "INSERT INTO conception (id_article, id_materiel) VALUES (:article_id, :material_id)";
                    $stmt = $conn->prepare($insert_conception_query);
                    $stmt->bindParam(':article_id', $last_article_id);
                    $stmt->bindParam(':material_id', $material_id);
                    $stmt->execute();
                }

                $_SESSION['success_message'] = "The article has been added successfully.";

                header("Location: article.php"); // Redirect to the form with a success message
                exit();
            } catch (PDOException $e) {
                $_SESSION['error_message'] = "Error: " . $e->getMessage();
                header("Location: form_add_article.php"); // Redirect to the form with an error message
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Error uploading the image.";
            header("Location: form_add_article.php"); // Redirect to the form with an error message
            exit();
        }
    } else {
        $_SESSION['error_message'] = "All fields are mandatory";
        header("Location: form_add_article.php"); // Redirect to the form with an error message
        exit();
    }
}
