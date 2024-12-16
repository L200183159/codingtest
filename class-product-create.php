<?php

class Product_Create {

    // Display the product creation form
    public function display_form() {
        ?>
        <h1>Create a New Product</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="product_name">Product Name</label></th>
                    <td><input type="text" name="product_name" id="
