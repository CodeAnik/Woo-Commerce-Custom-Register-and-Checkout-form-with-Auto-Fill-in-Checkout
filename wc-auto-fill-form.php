<?php
/**
 * Plugin Name: WC Auto Fill Form
 * Description: A custom WooCommerce registration form with auto-fill checkout fields.
 * Version: 1.0.3
 * Author: Md. Anik Khan
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define plugin path
define('WC_AFF_PATH', plugin_dir_path(__FILE__));
define('WC_AFF_URL', plugin_dir_url(__FILE__));

// Include main class
require_once WC_AFF_PATH . 'includes/class-wc-auto-fill-form.php';

// Include form handler
require_once WC_AFF_PATH . 'includes/form-handler.php';

// Initialize plugin
function wc_aff_init() {
    new WC_Auto_Fill_Form();
}
add_action('plugins_loaded', 'wc_aff_init');
