<?php include 'header.php';
$userLoggedIn = isset($_SESSION['user_id']) ? true : false;

// Définissez l'ID de l'utilisateur (s'il est connecté)
$userId = $userLoggedIn ? $_SESSION['user_id'] : '';
?>
<div class="productsContainer">

    <div class="headerCart">
        <i class="fa-solid fa-arrow-left"></i><a href="./Shop.php"></i>Continue Shopping</a>
        <!-- <h3>Your Cart</h3> -->
    </div>

    <div class="productHeader">
        <h5 class="productTitle">Product</h5>
        <h5 class="productPrice">Price</h5>
        <h5 class="ProductQuantity"></h5>
        <h5 class="productToral">Total</h5>
    </div>

    <div class="products">
        <div class="product">
            <!-- <div class="productsInfos">
                <i class="closeIcon fa-solid fa-x closeIconPanier"></i>
                <img src="./pic/earringImgPexlp.jpeg" alt="">
                <span>Collier</span>
            </div>
            <div class="productsPrice">
                <span>$25</span>
            </div>

            <div class="productsQuantity"></div>

            <div class="productsTotal">
                <span>$250</span>
            </div> 
-->
        </div>
    </div>


    <button class="cartCheckOutBtn" id="checkoutButton" data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">Valider la commande</button>



</div>



<script>
    // Assurez-vous que userId est défini dans le contexte global
    var userId = "<?php echo $userId; ?>";
</script>






<script src="../js/panier.js"></script>
<?php include 'footer.php'; ?>