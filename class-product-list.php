<?php

class Product_List {

    // Display products in a table format
    public function display_products() {
        // Get API credentials from WordPress options
        $api_url = get_option('api_endpoint_url');
        $consumer_key = get_option('consumer_key');
        $consumer_secret = get_option('consumer_secret');

        // Make API call to fetch products
        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret)
            )
        ));

        if (is_wp_error($response)) {
            echo 'Failed to fetch products: ' . $response->get_error_message();
            return;
        }

        $products = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($products)) {
            echo '<p>No products found.</p>';
            return;
        }

        // Display product list in table
        echo '<table class="widefat fixed">';
        echo '<thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Stock Status</th></tr></thead>';
        echo '<tbody>';

        foreach ($products as $product) {
            echo '<tr>';
            echo '<td>' . $product['id'] . '</td>';
            echo '<td>' . $product['name'] . '</td>';
            echo '<td>' . $product['price'] . '</td>';
            echo '<td>' . $product['stock_status'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
}
