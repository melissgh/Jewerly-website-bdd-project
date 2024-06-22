<?php
include 'header.php';

// Vérification si l'identifiant de l'article est passé via le lien
if(isset($_GET['article_id'])) {
    $article_id = $_GET['article_id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddproject";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération des informations de l'article en fonction de son identifiant
        $stmt = $conn->prepare("SELECT a.Nom_article, a.Description_article, a.Quantite, a.Prix, a.Image_article, a.description_materiel, c.nom_categorie, m.nom_materiel, co.id_materiel
                        FROM article a
                        LEFT JOIN categorie c ON a.id_cat = c.id_categorie
                        LEFT JOIN conception co ON a.ID_article = co.id_article
                        LEFT JOIN materiel m ON co.id_materiel = m.id_materiel
                        WHERE a.ID_article = :article_id");

$stmt->bindParam(':article_id', $article_id);
$stmt->execute();
$articleDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupération de tous les matériaux existants
        $stmtMaterials = $conn->query("SELECT id_materiel, nom_materiel FROM materiel");
        $allMaterials = $stmtMaterials->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<div class="add_article_form">
    <form action="modify_article.php" method="POST" enctype="multipart/form-data">
        <div class="form_group">
            <div class="field">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Article Name" value="<?php echo $articleDetails[0]['Nom_article']; ?>">
            </div>
            <div class="field">
            <label for="category">Category:</label>
    <select id="category" name="category">
        <?php
        $selectedCategory = $articleDetails[0]['nom_categorie']; // Catégorie de l'article
        $categories = array("Necklace", "bracelet", "Ring", "Engagement", "Earring");

        foreach ($categories as $category) {
            $selected = ($category === $selectedCategory) ? 'selected' : '';
            echo "<option value=\"$category\" $selected>$category</option>";
        }
        ?>
    </select>
            </div>
        </div>
        <div class="form_group">
            <div class="field">
                <label>Materials:</label><br>
                <?php foreach($allMaterials as $material) : ?>
                    <input type="checkbox" id="material<?php echo $material['id_materiel']; ?>" name="materials[]" value="<?php echo $material['nom_materiel']; ?>"
                        <?php foreach ($articleDetails as $articleMaterial) {
                            if ($material['id_materiel'] == $articleMaterial['id_materiel']) {
                                echo 'checked';
                                break;
                            }
                        } ?>>
                    <label for="material<?php echo $material['id_materiel']; ?>" class="lab"><?php echo $material['nom_materiel']; ?></label><br>
                <?php endforeach; ?>
            </div>
            <div class="field">
    <label for="material_description">Material Description:</label>
    <input type="text" id="material_description" name="material_description" placeholder="Material Description" value="<?php echo $articleDetails[0]['description_materiel']; ?>">
</div>

        </div>
        <div class="form_group">
            <div class="field">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" placeholder="Article Price" value="<?php echo $articleDetails[0]['Prix']; ?>" >
            </div>
            <div class="field">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Available Quantity" value="<?php echo $articleDetails[0]['Quantite']; ?>">
            </div>
        </div>
        <div class="form_group">
        <div class="field">
        <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*">
    <?php if (!empty($articleDetails[0]['Image_article'])) : ?>
        <p>Ancienne image : <?php echo $articleDetails[0]['Image_article']; ?></p>
    <?php endif; ?>
            </div>
            <div class="field">
                <label for="article_description">Article Description:</label>
                <input type="text" id="article_description" name="article_description" placeholder="Article Description" value="<?php echo $articleDetails[0]['Description_article']; ?>">
            </div>
        </div>
        <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
    <button type="submit">Modify</button>

    </form>
</div>
