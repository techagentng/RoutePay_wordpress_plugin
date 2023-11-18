<?php
/*
Plugin Name: RoutePay Payment Gateway
Description: Custom payment gateway integration for WooCommerce.
Version: 1.0
Author: Nnah Nnamdi
*/

// Include the main class file
include_once(plugin_dir_path(__FILE__) . '/routepay.gateway.php/includes/class-routepay-payment-gateway.php');

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    function route_pay_gateway_missing_wc_notice() {
        echo '<div class="error"><p>Please install and activate WooCommerce to use RoutePay Payment Gateway.</p></div>';
    }
    add_action('admin_notices', 'route_pay_gateway_missing_wc_notice');
} else {
    // Initialize the custom payment gateway
    function initialize_route_pay_gateway() {
        $route_pay_gateway = new RoutePay_Payment_Gateway();
    }
    add_action('plugins_loaded', 'initialize_route_pay_gateway');
}
