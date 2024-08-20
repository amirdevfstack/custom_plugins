<?php
/**
 * Plugin Name: WooCommerce Order Test - WP Fix It
 * Plugin URI:  https://www.wpfixit.com
 * Description: A testing payment gateway for WooCommerce to see if your checkout works like it should. You can complete a full and real checkout on your site to see if everything is running smoothly. This will be for admin users only.
 * Author:      WP Fix It
 * Author URI:  https://www.wpfixit.com
 * Version:     3.2
 * Text Domain: woo-order-test
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue plugin CSS
function wpfi_order_test_css() {
    wp_enqueue_style('wpfi_order_test_css', plugins_url('wcot.css', __FILE__), array(), '3.0');
}
add_action('admin_enqueue_scripts', 'wpfi_order_test_css');

// Add links to plugin settings and support page
function wpfi_plugin_action_links($links) {
    $settings_link = '<a href="' . esc_url(admin_url('/admin.php?page=wc-settings&tab=checkout&section=wpfi_woo_test')) . '">' . esc_html__('Settings', 'woo-order-test') . '</a>';
    $support_link = '<a href="https://www.wpfixit.com/" target="_blank"><b><span id="p-icon" class="dashicons dashicons-money-alt"></span> <span class="ticket-link">' . esc_html__('GET HELP', 'woo-order-test') . '</span></b></a>';
    array_unshift($links, $settings_link);
    array_unshift($links, $support_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wpfi_plugin_action_links');

// Add section to WooCommerce settings
function wpfi_add_woo_test_section($sections) {
    $sections['wpfi_woo_test'] = esc_html__('WooCommerce Order Test', 'woo-order-test');
    return $sections;
}
add_filter('woocommerce_get_sections_checkout', 'wpfi_add_woo_test_section');

// Add fields to the WooCommerce settings
function wpfi_add_woo_test_settings($settings, $current_section) {
    if ($current_section === 'wpfi_woo_test') {
        $settings[] = array(
            'title' => esc_html__('Order Testing For Admins', 'woo-order-test'),
            'type' => 'title',
            'id' => 'wpfi_woo_test_settings'
        );
        $settings[] = array(
            'title' => esc_html__('Enable Woo Order Test', 'woo-order-test'),
            'desc' => esc_html__('Enable/disable the payment bypass feature for administrators.', 'woo-order-test'),
            'id' => 'admin_payment_bypass_enabled',
            'default' => 'yes',
            'type' => 'checkbox',
            'desc_tip' => true,
        );
        $settings[] = array(
            'title' => esc_html__('Customize Testing Message', 'woo-order-test'),
            'desc' => esc_html__('Enter a custom message for testing purposes.', 'woo-order-test'),
            'id' => 'testing_message',
            'default' => esc_html__('Payment gateways are disabled for administrators for testing purposes and only', 'woo-order-test'),
            'type' => 'text',
            'css' => 'width: 100%; max-width: 600px;',
            'desc_tip' => true,
        );
        $settings[] = array(
            'type' => 'sectionend',
            'id' => 'wpfi_woo_test_settings'
        );
    }
    return $settings;
}
add_filter('woocommerce_get_settings_checkout', 'wpfi_add_woo_test_settings', 10, 2);

// Check if payment bypass is enabled for admin
function wpfi_is_payment_bypass_enabled_for_admin() {
    return current_user_can('administrator') && 'yes' === get_option('admin_payment_bypass_enabled', 'no');
}

// Disable payment gateway requirement for admin users
function wpfi_admin_cart_needs_payment($needs_payment) {
    if (wpfi_is_payment_bypass_enabled_for_admin() && is_checkout()) {
        return false;
    }
    return $needs_payment;
}
add_filter('woocommerce_cart_needs_payment', 'wpfi_admin_cart_needs_payment');

// Hide payment methods on checkout for admin users
function wpfi_admin_disable_payment_gateways($available_gateways) {
    if (is_checkout() && wpfi_is_payment_bypass_enabled_for_admin()) {
        return array();
    }
    return $available_gateways;
}
add_filter('woocommerce_available_payment_gateways', 'wpfi_admin_disable_payment_gateways');

// Automatically complete orders for admin users
function wpfi_admin_auto_complete_order($order_id) {
    if (!$order_id) return;
    if (wpfi_is_payment_bypass_enabled_for_admin()) {
        $order = wc_get_order($order_id);
        if ($order) {
            $order->update_status('completed');
        }
    }
}
add_action('woocommerce_thankyou', 'wpfi_admin_auto_complete_order');

// Bypass payment required step for admin users
function wpfi_admin_remove_payment_gateway_fields($fields) {
    if (is_checkout() && wpfi_is_payment_bypass_enabled_for_admin()) {
        unset($fields['order']['payment_method']);
    }
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wpfi_admin_remove_payment_gateway_fields');

// Prevent validation error for no payment method for admin users
function wpfi_admin_skip_payment_method_validation($data, $errors) {
    if (wpfi_is_payment_bypass_enabled_for_admin()) {
        $errors->remove('no_payment_method');
    }
}
add_action('woocommerce_after_checkout_validation', 'wpfi_admin_skip_payment_method_validation', 10, 2);

// Skip payment step in order creation for admin users
function wpfi_admin_order_needs_payment($needs_payment, $order) {
    if (wpfi_is_payment_bypass_enabled_for_admin()) {
        return false;
    }
    return $needs_payment;
}
add_filter('woocommerce_order_needs_payment', 'wpfi_admin_order_needs_payment', 10, 2);

// Activation hook
register_activation_hook(__FILE__, 'wpfi_plugin_activate');

function wpfi_plugin_activate() {
    // Force the option to be set to 'yes' upon activation
    update_option('admin_payment_bypass_enabled', 'yes');
}

/**
 * Display custom notice above theme header with inline styling.
 */
function display_custom_above_header_notice() {
    if (is_checkout() && wpfi_is_payment_bypass_enabled_for_admin()) {
        $custom_message = get_option('testing_message', esc_html__('Payment gateways are disabled for testing purposes.', 'woocommerce-order-test-wp-fix-it'));
        
        if (!empty($custom_message)) {
            echo '<div class="woocommerce-notices-wrapper">';
            echo '<div class="woocommerce-message" role="alert" style="background-color: #efe; border-bottom: 1px solid #ccc; text-align: center; padding: 10px 0; margin-bottom: 20px;">';
            
            // Modify or remove the pseudo-element content
            // Example: Removing the pseudo-element completely
            echo '<style>.woocommerce-message::before { content: none; }</style>';
            
            echo '<p>' . esc_html($custom_message) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    }
}
add_action('wp_body_open', 'display_custom_above_header_notice');