<?php include 'header.php'; ?>


<div class="main_right_buttom">
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddproject";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get the category from the URL (GET parameter)
        $category = isset($_GET['category']) ? $_GET['category'] : null;

        // Build the SQL query to retrieve articles based on the selected category
        if ($category && $category !== 'All') {
            $stmt = $conn->prepare("SELECT a.ID_article, a.Nom_article, a.Image_article, a.Description_article, a.Quantite, a.Prix 
                                        FROM article a
                                        JOIN categorie c ON a.id_cat = c.id_categorie
                                        WHERE c.nom_categorie = :category");
            $stmt->bindParam(':category', $category);
        } else {
            // If the category is "All" or if no parameter is defined, retrieve all articles
            $stmt = $conn->query("SELECT ID_article, Nom_article, Image_article, Description_article, Quantite, Prix FROM article");
        }

        $stmt->execute();
        $articles = $stmt->fetchAll();

        // Display articles corresponding to the selected category
        if (count($articles) > 0) {
            foreach ($articles as $article) {
    ?>
                <div class="box">

                    <div class="product_img">
                        <a href="article.php?article_id=<?php echo $article['ID_article']; ?>">
                            <img src="uploads/<?php echo $article['Image_article']; ?>" alt="" id="img">
                        </a>
                    </div>
                    <div class="detail">
                        <h3 id="nom"><?php echo $article['Nom_article']; ?></h3>
                        <p id="price"><?php echo $article['Prix']; ?> Da</p>
                        <div class="bottom-detail">
                            <?php
                            if ($article['Quantite'] == 0) {
                                echo '<span class="out-of-stock" style="color:red; font-size:25px;">Out of stock</span>';
                            } else {
                                echo '<span class="left-detail" id="quantity">' . $article['Quantite'] . '</span>';
                            }
                            ?>
                            <div class="right-detail">
                                <a href="delete_article.php?article_id=<?php echo $article['ID_article']; ?>" onclick="return confirm('Are you sure you want to delete this article?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a href="form_modify_article.php?article_id=<?php echo $article['ID_article']; ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            }
        } else {
            echo '<p style="text-align: center; color: red; font-size: 40px;">No articles found in this category.</p>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</div>
</div>