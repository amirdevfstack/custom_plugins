<?php
/*
Plugin Name: WooCommerce Color Variants
Description: Customizes WooCommerce product details page to display color variants and sizes in a table.
Version: 1.0
Author: Aamir Shahzad
*/

function woocommerce_color_variants_scripts() {
    wp_enqueue_style('custom-product-css', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('woocommerce-color-variants-script', plugin_dir_url(__FILE__) . 'assets/js/woocommerce-color-variants.js', array('jquery'), '1.0', true);
    wp_localize_script('woocommerce-color-variants-script', 'woocommerce_color_variants_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);

    wp_localize_script('custom-admin-script', 'ajax_object', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
}
add_action('wp_enqueue_scripts', 'woocommerce_color_variants_scripts');

add_action('wp_ajax_get_sizes_for_color_variant', 'get_sizes_for_color_variant_callback');
add_action('wp_ajax_nopriv_get_sizes_for_color_variant', 'get_sizes_for_color_variant_callback');





function get_sizes_for_color_variant_callback() {
    $data = [];
    $color_variant = isset($_POST['color_variant']) ? $_POST['color_variant'] : '';
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

    if ($color_variant && $product_id) {
        $product = wc_get_product($product_id);

        if ($product) {
            $variations = $product->get_available_variations();
            $sizes = array();

            foreach ($variations as $variation) {
                if ($variation['attributes']['attribute_pa_color'] === $color_variant) {
                    $variation_product = wc_get_product($variation['variation_id']);

                    if ($variation_product) {
                        $size = isset($variation['attributes']['attribute_pa_size']) ? $variation['attributes']['attribute_pa_size'] : '';
                        $price = floatval($variation_product->get_price());
                        $quantity = $variation_product->get_stock_quantity();
                        $image_url = wp_get_attachment_image_url($variation_product->get_image_id(), 'full');

                        // Get discount percentages
                        $discount1_pct = floatval(get_post_meta($variation['variation_id'], 'discount_pct_1', true));
                        $discount2_pct = floatval(get_post_meta($variation['variation_id'], 'discount_pct_2', true));
                        $discount3_pct = floatval(get_post_meta($variation['variation_id'], 'discount_pct_3', true));

                        // Calculate discounted prices
                        $price1 = $price - ($price * ($discount1_pct / 100));
                        $price2 = $price - ($price * ($discount2_pct / 100));
                        $price3 = $price - ($price * ($discount3_pct / 100));

                        $sizes[] = array(
                            'size' => $size,
                            'price1' => $price1,
                            'price2' => $price2,
                            'price3' => $price3,
                            'quantity' => $quantity,
                            'variation_id' => $variation['variation_id'],
                            'image_url' =>  $image_url
                        );
                    }
                }
            }

            wp_send_json($sizes);
        }
    }
}











// function get_sizes_for_color_variant_callback() {
//     $data = [];
//     $color_variant = isset($_POST['color_variant']) ? $_POST['color_variant'] : '';
//     $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
//     if ($color_variant && $product_id) {
//         $product = wc_get_product($product_id);

//         if ($product) {
//             $variations = $product->get_available_variations();
//             $sizes = array();

//             foreach ($variations as $variation) {
//                 if ($variation['attributes']['attribute_pa_color'] === $color_variant) {
//                     $variation_product = wc_get_product($variation['variation_id']);

//                     if ($variation_product) {
//                         $size = isset($variation['attributes']['attribute_pa_size']) ? $variation['attributes']['attribute_pa_size'] : '';
//                         $price = $variation_product->get_price();
//                         $quantity = $variation_product->get_stock_quantity();
//                         $image_url = wp_get_attachment_image_url($variation_product->get_image_id(), 'full');

//                         $sizes[] = array(
//                             'size' => $size,
//                             'price' => $price,
//                             'quantity' => $quantity,
//                             'variation_id' => $variation['variation_id'],
//                             'image_url' =>  $image_url
//                         );
//                     }
//                 }
//             }

//             wp_send_json($sizes);
//         }
//     }
// }

add_action('wp_ajax_add_all_to_cart', 'add_all_to_cart_callback');
add_action('wp_ajax_nopriv_add_all_to_cart', 'add_all_to_cart_callback');

function add_all_to_cart_callback() {
    $items = isset($_POST['items']) ? $_POST['items'] : [];

    foreach ($items as $item) {
        $product_id = $item['product_id'];
        $variation_id = $item['variation_id'];
        $quantity = $item['quantity'];
        $color_variant = $item['color_variant'];
        if ($product_id && $variation_id && $quantity) {
            WC()->cart->add_to_cart($product_id, $quantity, $variation_id, array('color_variant' => $color_variant));
        }
    }

    wp_send_json_success();
}

add_action('woocommerce_before_add_to_cart_button', 'append_variant_data_before_add_to_cart');

function append_variant_data_before_add_to_cart() {
    global $product;

    if ($product->is_type('variable')) {
        echo '<div id="variant-data-placeholder"></div>';
    }
}

add_filter('woocommerce_get_price_html', 'replace_price_with_description_for_variable_products', 10, 2);

function replace_price_with_description_for_variable_products($price, $product) {
    if ($product->is_type('variable')) {
        return '<div class="woocommerce-product-details__description">' . $product->get_description() . '</div>';
    }
    return $price;
}

add_filter('auto_update_plugin', 'disable_auto_update_for_variation_swatches', 10, 2);

function disable_auto_update_for_variation_swatches($update, $item) {
    if ($item->slug === 'woo-variation-swatches') {
        return false;
    }
    return $update;
}

function filter_plugin_updates( $value ) {
    unset( $value->response['woo-variation-swatches/woo-variation-swatches.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

// //dsicount applied to variable products

// Add custom fields to product variants in the admin area
add_action('woocommerce_product_after_variable_attributes', 'add_custom_discount_fields', 10, 3);
function add_custom_discount_fields($loop, $variation_data, $variation) {
    for ($i = 1; $i <= 3; $i++) {
        woocommerce_wp_text_input(array(
            'id' => 'discount_qty_' . $i . '[' . $variation->ID . ']',
            'label' => __('Discount Quantity ' . $i, 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'discount_qty_' . $i, true),
            'type' => 'number',
            'desc_tip' => true,
            'description' => __('Enter the quantity for discount ' . $i, 'woocommerce')
        ));
        
        woocommerce_wp_text_input(array(
            'id' => 'discount_pct_' . $i . '[' . $variation->ID . ']',
            'label' => __('Discount Percentage ' . $i, 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'discount_pct_' . $i, true),
            'type' => 'number',
            'desc_tip' => true,
            'description' => __('Enter the percentage for discount ' . $i, 'woocommerce')
        ));
    }
}

// Save custom fields for product variants
add_action('woocommerce_save_product_variation', 'save_custom_discount_fields', 10, 2);
function save_custom_discount_fields($variation_id, $i) {
    for ($i = 1; $i <= 3; $i++) {
        $qty_key = 'discount_qty_' . $i;
        $pct_key = 'discount_pct_' . $i;

        if (isset($_POST[$qty_key][$variation_id])) {
            update_post_meta($variation_id, $qty_key, sanitize_text_field($_POST[$qty_key][$variation_id]));
        }
        if (isset($_POST[$pct_key][$variation_id])) {
            update_post_meta($variation_id, $pct_key, sanitize_text_field($_POST[$pct_key][$variation_id]));
        }
    }
}



// Handle AJAX request for saving variation discounts
add_action('wp_ajax_save_variation_discounts', 'save_variation_discounts');
function save_variation_discounts() {
    if (!isset($_POST['variation_id']) || !isset($_POST['discounts'])) {
        wp_send_json_error();
    }

    $variation_id = intval($_POST['variation_id']);
    $discounts = $_POST['discounts'];

    for ($i = 1; $i <= 3; $i++) {
        if (isset($discounts[$i - 1])) {
            update_post_meta($variation_id, 'discount_qty_' . $i, sanitize_text_field($discounts[$i - 1]['qty']));
            update_post_meta($variation_id, 'discount_pct_' . $i, sanitize_text_field($discounts[$i - 1]['pct']));
        }
    }

    wp_send_json_success();
}

// Optional: Display discounted prices on the product page
// add_action('woocommerce_single_product_summary', 'display_variation_discounts', 25);
// function display_variation_discounts() {
//     global $product;

//     if ($product->is_type('variable')) {
//         $available_variations = $product->get_available_variations();
//         foreach ($available_variations as $variation) {
//             for ($i = 1; $i <= 3; $i++) {
//                 $qty = get_post_meta($variation['variation_id'], 'discount_qty_' . $i, true);
//                 $pct = get_post_meta($variation['variation_id'], 'discount_pct_' . $i, true);

//                 if ($qty && $pct) {
//                     $regular_price = $variation['display_regular_price'];
//                     $discounted_price = calculate_discounted_price($regular_price, $pct);

//                     echo '<p>Buy ' . esc_html($qty) . ' or more for $' . esc_html($discounted_price) . ' each!</p>';
//                 }
//             }
//         }
//     }
// }

// Helper function to calculate discounted price
function calculate_discounted_price($regular_price, $discount_percentage) {
    return $regular_price * (1 - ($discount_percentage / 100));
}





// Apply discount when adding to cart
add_action('woocommerce_before_calculate_totals', 'apply_variation_discounts', 10, 1);
function apply_variation_discounts($cart) {
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $variation_id = $cart_item['variation_id'];
        $quantity = $cart_item['quantity'];
        $original_price = $cart_item['data']->get_regular_price();
        $discounted_price = $original_price;  // Initialize with original price

        // Initialize discount variables
        $discount_qty_1 = get_post_meta($variation_id, 'discount_qty_1', true);
        $discount_pct_1 = get_post_meta($variation_id, 'discount_pct_1', true);

        $discount_qty_2 = get_post_meta($variation_id, 'discount_qty_2', true);
        $discount_pct_2 = get_post_meta($variation_id, 'discount_pct_2', true);

        $discount_qty_3 = get_post_meta($variation_id, 'discount_qty_3', true);
        $discount_pct_3 = get_post_meta($variation_id, 'discount_pct_3', true);

        // Apply discount based on quantity
        if ($discount_qty_1 && $quantity <= $discount_qty_1) {
            $discounted_price = calculate_discounted_price($original_price, $discount_pct_1);
        }
        if ($discount_qty_2 && $quantity > $discount_qty_1) {
            $discounted_price = calculate_discounted_price($original_price, $discount_pct_2);
        }
        if ($discount_qty_3 && $quantity > $discount_qty_2) {
            $discounted_price = calculate_discounted_price($original_price, $discount_pct_3);
        }

        // Update cart item price with the highest applicable discount
        $cart_item['data']->set_price($discounted_price);
    }
}























?>
