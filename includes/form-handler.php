<?php
if (!defined('ABSPATH')) {
    exit;
}

// Handle Registration Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wc_aff_register'])) {
    // Ensure WordPress core functions are available
    if (!function_exists('wp_hash_password')) {
        error_log('wp_hash_password() is not available');
        return;
    }

    // Validate password and confirm password
    $password = sanitize_text_field($_POST['password']);
    $confirm_password = sanitize_text_field($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo '<div class="error-message">Error: Passwords do not match.</div>';
        return;
    }

    // Create user
    $user_id = wp_insert_user(array(
        'user_login' => sanitize_text_field($_POST['email']),
        'user_email' => sanitize_text_field($_POST['email']),
        'user_pass'  => $password,
        'role'       => 'customer'
    ));

    if (!is_wp_error($user_id)) {
        // Save additional user meta
        update_user_meta($user_id, 'business_name', sanitize_text_field($_POST['business_name']));
        update_user_meta($user_id, 'owner_name', sanitize_text_field($_POST['owner_name']));
        update_user_meta($user_id, 'country', sanitize_text_field($_POST['country']));
        update_user_meta($user_id, 'state', sanitize_text_field($_POST['state']));
        update_user_meta($user_id, 'business_address', sanitize_text_field($_POST['business_address']));
        update_user_meta($user_id, 'city', sanitize_text_field($_POST['city']));
        update_user_meta($user_id, 'vat_number', sanitize_text_field($_POST['vat_number']));
        update_user_meta($user_id, 'registration_number', sanitize_text_field($_POST['registration_number']));
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));

        // Display success message
        echo '<div class="success-message">Registration successful! You can now log in.</div>';
    } else {
        // Display error message if user creation fails
        echo '<div class="error-message">Error: ' . $user_id->get_error_message() . '</div>';
    }
}