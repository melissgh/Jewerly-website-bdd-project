<?php include 'header.php';
include '../model/getArticleCategorie.php'
?>
<div class="shopage">
    <div class="shopRigth">
        <div class="shopRigthTop">
            <div class="shopRigthTopTop">
                <h2>Shop</h2>
            </div>
            <div class="shopRigthTopTopButtom">
                <button class="filterButton">ALL FILTERS + SORT</button>
                <ul>
                    <li><a href="./Shop.php">Shop All </a></li>
                    <li><a href="./Necklace.php">Necklaces</a></li>
                    <li><a href="./rings.php">Rings</a></li>
                    <li><a href="./earring.php">Earrings</a></li>
                    <li><a href="./bracelet.php">Bracelets</a></li>
                    <li><a href="./engagement.php">Engagement</a></li>
                    <li class="ItemSearchBox">
                        <form method="" action="">
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

            getAllArticlesByCategory("Ring");
            ?>

        </div>
    </div>
</div>