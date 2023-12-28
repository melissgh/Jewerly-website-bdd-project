<?php include 'header.php';

if (isset($_GET['searchItemName'])) {
    $searchTerm = $_GET['searchItemName'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddproject";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id_categorie FROM categorie WHERE nom_categorie LIKE :searchTerm");
        $searchTermCat = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTermCat);
        $stmt->execute();
        $cat_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $articles = [];
        if (count($cat_ids) > 0) {
            $in = str_repeat('?,', count($cat_ids) - 1) . '?';
            $stmt = $conn->prepare("SELECT ID_article, Nom_article, Image_article, Description_article, Quantite, Prix 
                                    FROM article
                                    WHERE id_cat IN ($in)");
            $stmt->execute($cat_ids);
            $articles = $stmt->fetchAll();
        } else {
            $stmt = $conn->prepare("SELECT ID_article, Nom_article, Image_article, Description_article, Quantite, Prix 
                                    FROM article
                                    WHERE Nom_article LIKE :searchTerm");
            $searchTerm = '%' . $searchTerm . '%';
            $stmt->bindParam(':searchTerm', $searchTerm);
            $stmt->execute();
            $articles = $stmt->fetchAll();
        }

        if (count($articles) > 0) {
            ?>

            <div class="main_right_buttom">
                <div class="main_right_buttom">
                    <?php
                    foreach ($articles as $article) {
                        ?>
                        <div class="box">
                            <div class="product_img">
                                <img src="uploads/<?php echo $article['Image_article']; ?>" alt="" id="img">
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
                    ?>
                </div>
            </div>
        <?php
        } else {
            echo '<p style="text-align: center; color: red; font-size: 40px;">Aucun article correspondant trouvé.</p>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
