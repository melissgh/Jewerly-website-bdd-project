<?php include 'header.php';

?>
<div class="shopage">
    <!-- <div class="shopLeft">
                <h3>Shop</h3>
                <ul>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Best Sallers</a></li>
                    <li><a href="#">Shop All </a></li>
                    <li><a href="#">Necklaces</a></li>
                    <li><a href="#">Rings</a></li>
                    <li><a href="#">Earrings</a></li>
                    <li><a href="#">Bracelets</a></li>
                    <li><a href="#">Wedding</a></li>
                    <li><a href="#">Men's</a></li>
                    <li><a href="#">kids</a></li>
                </ul>
            </div>  -->


    <div class="shopRigth">
        <div class="shopRigthTop">
            <div class="shopRigthTopTop">
                <h2>Shop</h2>
            </div>
            <div class="shopRigthTopTopButtom">
                <button class="filterButton">ALL FILTERS + SORT</button>
                <ul>
                    <li><a href="./home.php#new">New Arrivals</a></li>
                    <li><a href="./Shop.php">Shop All</a></li>
                    <li><a href="Necklace.php">Necklaces</a></li>
                    <li><a href="rings.php">Rings</a></li>
                    <li><a href="earring.php">Earrings</a></li>
                    <li><a href="bracelet.php">Bracelets</a></li>
                    <li><a href="engagement.php">Engagement</a></li>
                    <li class="ItemSearchBox">
                        <form method="POST" action="./rechercheshop.php">
                            <input class="searchInputItemName" type="search" placeholder="Srearch for items" name="serachitemName">
                            <button type="submit" name="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="shopRigthbuttom">




            <?php


            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bddproject";


            function RechercheAffiche($articleId, $article)
            {

                $userLoggedIn = isset($_SESSION['user_id']) ? true : false;
                $userId = $userLoggedIn ? $_SESSION['user_id'] : '';


                echo '<div class="NewArrivalArticle shopArticles">';
                echo '  <div class="NewArrivalArticleImg" onclick="redirectToItemPage(\'article.php?id=' . $article['ID_article'] . '\')">';
                #echo '<p>' . $article['ID_article'] . '</p>';
                #echo '<p>' . $userId . '</p>';
                echo '    <img src="../../admin/php/uploads/' . $article['Image_article'] . '" alt="' . $article['Nom_article'] . '" data-tag="' . $article['Image_article'] . '" data-img="' . $article['Image_article'] . '"   >';

                echo '        <button id="likebtn" class="likebtn"><i class="fa-regular fa-heart"></i></button>';
                echo '    </div>';
                echo '    <div class="NewArrivalArticleName">';
                echo '        <p>' . $article['Nom_article'] . '</p>';
                echo '        <div class="plusinfo">';
                echo '            <p>' . $article['Prix'] . 'DA</p>';
                echo '            <a href="#" class="articlebtnBag" data-id="' . $article['ID_article'] . '" data-id-client="' . $userId . '"><i class="fa-solid fa-cart-shopping"></i></a>
    ';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }


            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Vérifiez si le formulaire a été soumis
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Récupérez le terme de recherche
                    $searchTerm = $_POST["serachitemName"];

                    // Échappez les caractères spéciaux pour éviter les injections SQL
                    $searchTerm = "%$searchTerm%"; // Ajoutez des % pour correspondre à n'importe quelle partie du nom

                    // Construisez la requête SQL avec des paramètres préparés pour la sécurité
                    $sql = "SELECT * FROM article WHERE Nom_article LIKE :searchTerm AND Quantite > 0";

                    // Préparez la requête
                    $stmt = $conn->prepare($sql);

                    // Liez le paramètre
                    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);

                    // Exécutez la requête
                    $stmt->execute();

                    // Récupérez les résultats en tant qu'array associatif
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Vérifiez s'il y a des résultats
                    if (count($result) > 0) {
                        // Parcourez les résultats et appelez la fonction d'affichage
                        foreach ($result as $row) {
                            RechercheAffiche($row['ID_article'], $row); // Passez l'ID et les données de l'article à la fonction d'affichage
                        }
                    } else {
                        echo '<p style="text-align: center; color: red; font-size: 40px;">No available articles in this category.</p>';
                    }
                }

                // ...

                // Fermez la connexion à la base de données
                $conn = null;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }




            ?>







        </div>
    </div>
</div>




<div class="filtre">
    <div class="filtreTitle">
        <h3>Filters</h3>
        <i class="closeIcon fa-solid fa-x"></i>
    </div>

    <ul>
        <li>
            <div class="show">
                <p>Category</p>
                <!-- <button onclick="showHiddenCatego()"><i class="fa-solid fa-plus"></i></button> -->
                <!-- <button onclick="hidecatego()"><i class="fa-solid fa-minus"></i></button> -->

            </div>

            <div class="hiddenCatego hidden">

                <input type="radio" id="Necklace" name="category" value="Necklace">
                <label for="Necklace">Necklace</label><br>

                <input type="radio" id="Ring" name="category" value="Ring">
                <label for="Ring">Ring</label><br>

                <input type="radio" id="Earring" name="category" value="Earring">
                <label for="Earring">Earring</label> <br>

                <input type="radio" id="Bracelet" name="category" value="Bracelet">
                <label for="Bracelet">Bracelet</label> <br>

                <input type="radio" id="Wedding" name="category" value="Wedding">
                <label for="Wedding">Wedding</label> <br>
            </div>
        </li>


        <li>
            <div class="show">
                <p>Metal</p>
                <!-- <button onclick="showHiddenMetal()"><i class="fa-solid fa-plus"></i></button> -->
                <!-- <button onclick="hideMetal()"><i class="fa-solid fa-minus"></i></button> -->
            </div>

            <div class="hiddenMetal hidden">
                <input type="checkbox" id="metal1" name="metal1" value="">
                <label for="metal1"> 14K White Gold</label><br>

                <input type="checkbox" id="metal2" name="metal2" value="">
                <label for="metal2">14K Yellow Gold</label><br>

                <input type="checkbox" id="metal3" name="metal3" value="">
                <label for="metal3">Gold Vermiel</label><br>

                <input type="checkbox" id="metal4" name="metal4" value="">
                <label for="metal4">Sterling Silver</label><br>


            </div>
        </li>

        <div class="show">
            <p>Price</p>
            <!-- <button><i onclick="showHiddenPrice()" class="fa-solid fa-plus"></i></button> -->
            <!-- <button onclick="hidePrice()"><i class="fa-solid fa-minus"></i></button> -->
        </div>

        <div class="hidden hiddenPrice">

            <input type="checkbox" id="price1" name="price1" value="">
            <label for="price1">Under 150 </label><br>


            <input type="checkbox" id="price2" name="price2" value="">
            <label for="price2">150 - 300</i> </label><br>


            <input type="checkbox" id="price3" name="price3" value="">
            <label for="price3">300 - 500</i> </label><br>


            <input type="checkbox" id="price4" name="price4" value="">
            <label for="price4"></i>500+</label><br>
        </div>
        </li>

    </ul>

</div>


<div class="promotion">
    <h1>PROMOTION !!</h1>
</div>



<script src="../js/app.js"></script>
<script src="../js/panier.js"></script>

<?php include 'footer.php' ?>