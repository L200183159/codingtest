<?php
/**
 * Plugin Name: Custom Products API Integration
 * Description: A plugin to manage products on a remote WooCommerce site via API.
 * Version: 1.0
 * Author: Naura
 * License: GPL2
 */

defined('ABSPATH') or die('No script kiddies please!');

// Include required files
require_once(plugin_dir_path(__FILE__) . 'includes/class-product-list.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-product-create.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-config.php');

// Activation hook to initialize settings
register_activation_hook(__FILE__, 'custom_products_api_activate');

// Register admin menu
add_action('admin_menu', 'custom_products_api_menu');

// Enqueue scripts and styles for the admin interface
add_action('admin_enqueue_scripts', 'custom_products_api_enqueue_scripts');

// Activation function to create default settings
function custom_products_api_activate() {
    if (!get_option('api_endpoint_url')) {
        add_option('api_endpoint_url', 'https://stagingdeveloper.site/wp-json/wc/v3/products/');
    }
    if (!get_option('consumer_key')) {
        add_option('consumer_key', 'ck_163b2bdae4fa4b1ac67995791ae2cb7c85eb6783');
    }
    if (!get_option('consumer_secret')) {
        add_option('consumer_secret', 'cs_4ae0e0046218ee828fa8a506f0b7bbdaf39ea19e');
    }
}

// Create the admin menu
function custom_products_api_menu() {
    add_menu_page('Custom Products API', 'Products API', 'manage_options', 'custom-products-api', 'custom_products_api_main_page');
    add_submenu_page('custom-products-api', 'List Products', 'List Products', 'manage_options', 'custom-products-api-list', 'custom_products_api_list_page');
    add_submenu_page('custom-products-api', 'Create Product', 'Create Product', 'manage_options', 'custom-products-api-create', 'custom_products_api_create_page');
    add_submenu_page('custom-products-api', 'Configuration', 'Configuration', 'manage_options', 'custom-products-api-config', 'custom_products_api_config_page');
}

// Main page callback function
function custom_products_api_main_page() {
    echo '<h1>Welcome to Custom Products API Plugin</h1>';
    echo '<p>Manage products on the remote WooCommerce site.</p>';
}

// List Products page callback function
function custom_products_api_list_page() {
    $product_list = new Product_List();
    $product_list->display_products();
}

// Create Product page callback function
function custom_products_api_create_page() {
    $product_create = new Product_Create();
    $product_create->display_form();
}

// Configuration page callback function
function custom_products_api_config_page() {
    $config = new Config();
    $config->display_settings_form();
}

// Enqueue necessary scripts and styles for the admin pages
function custom_products_api_enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_custom-products-api') {
        return;
    }
    wp_enqueue_style('custom-products-api-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('custom-products-api-script', plugin_dir_url(__FILE__) . 'assets/js/script.js');
}
