<?php include 'header.php';
include '../../accueil/model/getCommentaire.php';
?>
<div class="article">
    <?php
    // Récupérer l'ID de l'article depuis l'URL
    $article_id = isset($_GET['article_id']) ? $_GET['article_id'] : null;

    if ($article_id) {
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bddproject";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer les détails de l'article en utilisant $article_id
            $stmt = $conn->prepare("SELECT Nom_article, Prix, image_article, Quantite, description_materiel, Description_article FROM article WHERE ID_article = :article_id");
            $stmt->bindParam(':article_id', $article_id);
            $stmt->execute();
            $article_details = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($article_details) {
                $article_name = $article_details['Nom_article'];
                $article_price = $article_details['Prix'];
                $article_quantite = $article_details['Quantite'];
                $article_description = $article_details['Description_article'];
                $image_article = $article_details['image_article'];
                $article_material = '';

                // Requête pour récupérer les matériaux de l'article depuis la table "conception"
                $stmt_materials = $conn->prepare("SELECT materiel.nom_materiel FROM conception INNER JOIN materiel ON conception.id_materiel = materiel.id_materiel WHERE conception.id_article = :article_id");
                $stmt_materials->bindParam(':article_id', $article_id);
                $stmt_materials->execute();
                $materials = $stmt_materials->fetchAll(PDO::FETCH_COLUMN);

                if ($materials) {
                    $article_material = implode(", ", $materials);
                }
    ?>
                <div class="articlePic">
                    <img src="../../admin/php/uploads/<?php echo $image_article; ?>" alt="" id="img" style="height:500px;width:100%;">
                </div>
                <div class="articleInfo">
                    <div class="articleTitlePrice">
                        <h2><?php echo $article_name; ?></h2>
                        <div class="Price">
                            <p class="priceNoPromo"><?php echo $article_price; ?> DA</p>
                        </div>
                    </div>

                    <div class="articleMetal">
                        <h2>Materials</h2>
                        <h3 class="materialName"><?php echo $article_material; ?></h3>
                    </div>
                    <div class="articleMetal">
                        <h2>Quantity</h2>
                        <h3 class="materialName"><?php echo $article_quantite; ?></h3>
                    </div>

                    <div class="articleDescription">
                        <h2>Description</h2>
                        <p><?php echo $article_description; ?></p>
                    </div>

                    <div class="articlebtn">
                        <form action="form_modify_article.php" method="GET">
                            <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                            <button type="submit" class="articlebtnBag">Modify</button>
                        </form>
                    </div>
                </div>
    <?php
            } else {
                echo '<p style="text-align: center; color: red; font-size: 40px;">Aucun détail trouvé pour cet article.</p>';
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Gérer le cas où aucun ID d'article n'est passé dans l'URL
        echo '<p style="text-align: center; color: red; font-size: 40px;">Aucun article sélectionné.</p>';
    }
    ?>
</div>



<?php
if ($article_id && $article_details) {
    // Affichage de la section des avis seulement si un article est sélectionné et que ses détails sont trouvés 
?>
    <?php
    // Récupération et affichage des commentaires pour cet article
    $comments = getCommentsByArticleId($article_id);

    if ($comments) {
        echo '<div class="articleReviews" id="articleReviews">';
        echo '<h1>Reviews</h1>';
        echo '<div class="reviewsBox">';
        foreach ($comments as $comment) {
            echo '<div class="review">';
            echo '<div class="reviewPost">';
            echo '<h2>' . $comment['client_prenom'] . '</h2>'; // Affiche le nom du client
            echo '</div>';
            echo '<div class="reviewDetails">';
            echo '<div class="reviewTitleDate">';
            echo '<h2>' . $comment['client_email'] . '</h2>'; // Remplacez par le email du client
            echo '<p>' . $comment['id_date'] . '</p>'; // Affiche la date du commentaire
            echo '</div>';
            echo '<div class="reviewMsg">';
            echo '<p>' . $comment['contenu'] . '</p>'; // Affiche le contenu du commentaire
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p style="text-align: center; color: red; font-size: 40px;">Aucun commentaire pour cet article.</p>';
    }
    ?>
    <!-- <div class="articleReviews" id="articleReviews">
        <h1>Reviews</h1>
        <div class="reviewsBox">
            <div class="review">
                <div class="reviewPost">
                    <h2>Jude B.</h2>
                </div>
                <div class="reviewDetails">
                    <div class="reviewTitleDate">
                        <h2>Love these</h2>
                        <p>13/12/2023</p>
                    </div>
                    <div class="reviewMsg">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur a aperiam dolores vero laudantium suscipit corrupti quo eligendi minus, quibusdam perferendis repudiandae mollitia, libero laboriosam totam repellat fugit hic ab ipsa nihil deleniti nesciunt molestias error? Accusamus harum dolorem reiciendis!</p>
                    </div>
                </div>
            </div>
            <div class="review">
                <div class="reviewPost">
                    <h2>Jude B.</h2>
                </div>
                <div class="reviewDetails">
                    <div class="reviewTitleDate">
                        <h2>Love these</h2>
                        <p>13/12/2023</p>
                    </div>
                    <div class="reviewMsg">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur a aperiam dolores vero laudantium suscipit corrupti quo eligendi minus, quibusdam perferendis repudiandae mollitia, libero laboriosam totam repellat fugit hic ab ipsa nihil deleniti nesciunt molestias error? Accusamus harum dolorem reiciendis!</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<?php
}
?>