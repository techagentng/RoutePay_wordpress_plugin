<?php
/*
 * Plugin Name: RoutePay Payment Gateway
 * Plugin URI: 
 * Description: Take care of payments on your store.
 * Author: Routepay
 * Author URI: http://routepay.com
 * Version: 1.0.1
 */

add_filter( 'woocommerce_payment_gateways', 'routepay_gateway_class' );
function routepay_gateway_class( $methods ) {
    $methods[] = 'Routepay_Gateway'; // your class name is here
    return $methods;
}

add_action( 'plugins_loaded', 'routepay_init_gateway_class' );
function routepay_init_gateway_class() {
    class Routepay_Gateway extends WC_Payment_Gateway {
        private $api_key;
        private $api_secret;
        private $private_key;
        private $publishable_key;
        public function __construct() {
            $this->id = 'routepay';
            $this->icon = '';
            $this->has_fields = true;
            $this->method_title = 'Routepay Gateway';
            $this->method_description = 'Pay with your debit card via our page. Powered by Routepay.';
            $this->supports = array( 'products' );

            $this->init_form_fields();
            $this->init_settings();
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->enabled = $this->get_option( 'enabled' );
            $this->testmode = 'yes' === $this->get_option( 'testmode' );
            $this->api_key = $this->testmode ? $this->get_option( 'test_api_key' ) : $this->get_option( 'api_key' );
            $this->api_secret = $this->testmode ? $this->get_option( 'test_api_secret' ) : $this->get_option( 'api_secret' );
            $this->private_key = $this->testmode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
            
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );
        }

        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => 'Enable/Disable',
                    'type'    => 'checkbox',
                    'label'   => 'Enable My Payment Gateway',
                    'default' => 'yes',
                ),
                'api_key' => array(
                    'title'       => 'API Key',
                    'type'        => 'text',
                    'description' => 'Enter your API key.',
                    'default'     => '',
                ),
                'api_secret' => array(
                    'title'       => 'API Secret',
                    'type'        => 'password',
                    'description' => 'Enter your API secret.',
                    'default'     => '',
                ),
                'private_key' => array(
                    'title'       => 'Private Key',
                    'type'        => 'text',
                    'description' => 'Enter your private key.',
                    'default'     => '',
                ),
                'publishable_key' => array(
                    'title'       => 'Publishable Key',
                    'type'        => 'text',
                    'description' => 'Enter your publishable key.',
                    'default'     => '',
                ),
                // ... other settings fields
            );
        }
        

        function process_admin_options() {
            parent::process_admin_options();
            
            // Additional logic to save settings
            $this->api_key = $this->get_option('api_key');
            $this->api_secret = $this->get_option('api_secret');
        }

        public function payment_fields() {
            // You can customize your payment fields here
        }

        public function payment_scripts() {
            // Custom CSS and JS can be added here
        }

        public function process_payment($order_id) {
            // Get the order object
            $order = wc_get_order($order_id);
        
            // Ensure that order data is present
            if (!$order) {
                wc_add_notice('Invalid order.', 'error');
                return;
            }
        
            // Set up your payment processor endpoint and credentials
            $request_url = "https://authdev.routepay.com/connect/token";
            $client_id = $this->get_option('api_key'); // Use the saved API key from settings
            $client_secret = $this->get_option('api_secret'); // Use the saved API secret from settings

            // Set up the payload
            $payload = array(
                'grant_type' => 'client_credentials',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            );
        
            // Make the POST request using wp_safe_remote_post
            $response = wp_safe_remote_post($request_url, array(
                'body' => $payload,
            ));
        
            // Check for errors in the request
            if (is_wp_error($response)) {
                // Handle error
                wc_add_notice('Error communicating with the payment processor.', 'error');
                return;
            }
        
            // Process the response
            $body = json_decode(wp_remote_retrieve_body($response), true);
        
            // Check if the access token is present in the response
            if (isset($body['access_token'])) {
                // Token obtained successfully, you can use $body['access_token'] in further API requests
                // Add your payment processing logic here
        
                // Construct the payment payload
                $payment_payload = array(
                    'merchantId' => $client_id,
                    'returnUrl' => 'http://www.test.com/return',
                    'merchantReference' => rand(), // Generating a random integer for merchantReference
                    'totalAmount' => $order->get_total(),
                    'currency' => get_woocommerce_currency(),
                    'customer' => array(
                        'email' => $order->get_billing_email(),
                        'mobile' => $order->get_billing_phone(),
                        'firstname' => $order->get_billing_first_name(),
                        'lastname' => $order->get_billing_last_name(),
                        'username' => $order->get_billing_company(), // You can adjust this based on your needs
                    ),
                    'products' => array(),
                );
        
                // Continue with your existing code...
                $payment_response = wp_safe_remote_post('https://apidev.routepay.com/payment/api/v1/Payment/SetRequest', array(
                    'body' => json_encode($payment_payload),
                    'headers' => array('Content-Type' => 'application/json'),
                ));
        
                // Continue with your existing code...
            } else {
                // Handle the case where the token was not obtained successfully
                wc_add_notice('Failed to obtain access token from the payment processor.', 'error');
                return;
            }
        }
    }
}
