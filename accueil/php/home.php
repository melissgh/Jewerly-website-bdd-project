<?php include './header.php';
?>
<div class="backImg">
    <!-- <div class="homeleft">
                <h3>ETHICAL JEWELLERY</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ea accusantium sed nobis distinctio fuga doloribus placeat commodi fugit incidunt Lorem ipsum dolor sit amet, consectetur adipisicing elit.  commodi</p>

                <button><a href="collection.html">Shop The Collection</a> </button>
            </div>
            <div class="homerigth">
                <h1>modo jewellery</h1>
            </div> -->

    <div class="logo">
        <h1>Modo </h1>
        <h1>jewellery</h1>
    </div>

    <div class="headerImg">
        <div class="image"></div>
        <div class="callToActionHeader">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam, quia? dolor sit amet consectetur adipisicing</p>
            <a href="shop.php"> <button>Shop The Collection</button></a>
        </div>

    </div>

</div>

<?php include 'NewArrivals.php'; ?>


<div class="categorie">
    <div class="categorieTitle">
        <h3>Shop by Category</h3>
        <p>Brilliant design and unparalleled craftsmanship.</p>
    </div>

    <div class="categorieArticles">
        <div class="collier">
            <div class="layer">
                <h3>Nicklace</h3>
                <a href="./Necklace.html"><button>Shop</button></a>
            </div>
        </div>
        <div class="bag">
            <div id="bagLayer" class="layer">
                <h3>Ring</h3>
                <a href="./Ring.php"><button>Shop</button></a>
            </div>
        </div>
        <div class="erring">
            <div id="earringLayer" class="layer">
                <h3>Earring</h3>
                <a href="#"><button>Shop</button></a>
            </div>
        </div>
        <div class="bracellete">
            <div id="braceletLayer" class="layer">
                <h3>Bracelet</h3>
                <a href="#"><button>Shop</button></a>
            </div>
        </div>
        <div class="loveAndEngagment">
            <div id="engagmentLayer" class="layer">
                <h3>Engagement </h3>
                <a href="#"><button>Shop</button></a>
            </div>
        </div>

        <div class="info">
            <p>Lorem ipsum dolor sit, amet consectetur adip.</p>
            <a href="Shop.php"><button>Shop The Collection</button></a>
        </div>
    </div>

</div>

<div class="contact" id="contact">
    <h2>Have a Question Or Just Want To Say Hi ?</h2>

    <form method="" action="">
        <div class="formLeft">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="text" placeholder="First name" name="first_name" value="" id="first_name">
            <input type="text" placeholder="Last name" name="last_name" value="" id="last_name">
        </div>

        <div class="formRight">
            <textarea name="message" id="msginput" placeholder="Type your message here" maxlength="100"></textarea>
            <input type="submit" name="submit" id="sendInput" value="Send">
        </div>
    </form>

</div>

<div id="about" class="about">
    <div class="aboutInf">
        <div class="aboutLeft">
            <h3>About Us</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum perspiciatis cum id asperiores adipisci perferendis aut aperiam tenetur odio quidem. Architecto expedita cumque a iste fugit hic asperiores voluptatem similique beatae, totam non, facere quisquam dolorem. Quaerat itaque quod, commodi, <br><br> odit deserunt error ut voluptatem a nostrum ex modi quo.
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum perspiciatis cum id asperiores adipisci perferendis aut aperiam tenetur odio quidem.
            </p>
            <a href="about.php"><button>Read More</button></a>
        </div>

        <div class="aboutImg"></div>
    </div>
</div>
<script src="../js/panier.js"></script>

<?php include 'footer.php'; ?>