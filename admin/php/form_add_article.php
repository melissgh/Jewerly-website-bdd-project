<?php

include 'header.php';
?>

<div class="add_article_form">

    <form action="add_article.php" method="POST" enctype="multipart/form-data">
        <div class="form_group">
            <div class="field">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Article Name">
            </div>
            <div class="field">

                <label for="category">Category:</label>
                <select id="category" name="category">
                    <option value="Necklace">Necklace</option>
                    <option value="bracelet">bracelet</option>
                    <option value="Ring">Ring</option>
                    <option value="Engagement">Engagement</option>
                    <option value="Earring">Earring</option>

                </select>
            </div>
        </div>
        <div class="form_group">
            <div class="field">
                <label>Materials:</label><br>
                <input type="checkbox" id="material1" name="materials[]" value="14K White Gold">
                <label for="material1" class="lab">14K White Gold</label><br>
                <input type="checkbox" id="material2" name="materials[]" value="14K Yellow Gold">
                <label for="material2" class="lab">14K Yellow Gold</label><br>
                <input type="checkbox" id="material3" name="materials[]" value="Gold Vermeil">
                <label for="material3" class="lab">Gold Vermeil</label><br>
                <input type="checkbox" id="material4" name="materials[]" value="Sterling Silver">
                <label for="material4" class="lab">Sterling Silver</label>
                <!-- Add other checkboxes as needed -->
            </div>
            <div class="field">
                <label for="material_description">Material Description:</label>
                <input type="text" id="material_description" name="material_description" placeholder="Material Description">
            </div>
        </div>
        <div class="form_group">
            <div class="field">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" placeholder="Article Price">
            </div>
            <div class="field">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Available Quantity">
            </div>
        </div>
        <div class="form_group">
            <div class="field">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="field">
                <label for="article_description">Article Description:</label>
                <input type="text" id="article_description" name="article_description" placeholder="Article Description">
            </div>
        </div>
        <button type="submit">Add</button>
    </form>
</div>
