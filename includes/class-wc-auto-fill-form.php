<?php
if (!defined('ABSPATH')) {
    exit; // Direct access protection
}

class WC_Auto_Fill_Form {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_shortcode('wc_auto_fill_registration', array($this, 'render_registration_form'));
        add_shortcode('wc_auto_fill_checkout_form', array($this, 'render_checkout_form'));
        add_filter('woocommerce_checkout_fields', array($this, 'modify_checkout_fields'));
        add_action('woocommerce_checkout_update_order_meta', array($this, 'save_custom_checkout_fields'));
        add_action('woocommerce_before_checkout_form', array($this, 'hide_shipping_fields'));
    }

    // Load CSS
    public function enqueue_styles() {
        wp_enqueue_style('wc-aff-style', WC_AFF_URL . 'assets/style.css');
    }

    // Render Registration Form (Shortcode: [wc_auto_fill_registration])
    public function render_registration_form() {
        ob_start();
        include(WC_AFF_PATH . 'templates/registration-form.php');
        return ob_get_clean();
    }

    // Render Checkout Form (Shortcode: [wc_auto_fill_checkout_form])
    public function render_checkout_form() {
        ob_start();
        include(WC_AFF_PATH . 'templates/checkout-form.php');
        return ob_get_clean();
    }

    // Modify WooCommerce Checkout Fields
    public function modify_checkout_fields($fields) {
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $fields['billing']['billing_company']['default'] = get_user_meta($user_id, 'business_name', true);
            $fields['billing']['billing_first_name']['default'] = get_user_meta($user_id, 'owner_name', true);
            $fields['billing']['billing_country']['default'] = get_user_meta($user_id, 'country', true);
            $fields['billing']['billing_state']['default'] = get_user_meta($user_id, 'state', true);
            $fields['billing']['billing_address_1']['default'] = get_user_meta($user_id, 'business_address', true);
            $fields['billing']['billing_city']['default'] = get_user_meta($user_id, 'city', true);
            $fields['billing']['billing_email']['default'] = get_user_meta($user_id, 'email', true);
            $fields['billing']['billing_phone']['default'] = get_user_meta($user_id, 'phone', true);
        }

        // Remove shipping fields
        unset($fields['shipping']);

        return $fields;
    }

    // Hide Shipping Fields
    public function hide_shipping_fields() {
        echo '<style>
            #ship-to-different-address, .shipping_address { display: none !important; }
        </style>';
    }

    // Save Custom Checkout Fields
    public function save_custom_checkout_fields($order_id) {
        if (!empty($_POST['business_name'])) {
            update_post_meta($order_id, 'Business Name', sanitize_text_field($_POST['business_name']));
        }
        if (!empty($_POST['owner_name'])) {
            update_post_meta($order_id, 'Owner Name', sanitize_text_field($_POST['owner_name']));
        }
        // Add more fields as needed
    }
}

// Initialize the Plugin Class
new WC_Auto_Fill_Form();