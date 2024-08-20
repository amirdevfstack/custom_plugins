<?php
/*
Plugin Name: Competition Customization
Description: Customizations for the WooCommerce product details page for win.boo competition.
Version: 1.0
Author: Waseem Ahmad
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


add_action( 'woocommerce_product_options_general_product_data', 'win_boo_add_custom_general_fields' );

function win_boo_add_custom_general_fields() {
    global $woocommerce, $post;
    
    echo '<div class="options_group">';
    
    woocommerce_wp_text_input( 
        array( 
            'id'          => '_draw_date', 
            'label'       => __( 'Draw Date', 'woocommerce' ), 
            'placeholder' => 'YYYY-MM-DD',
            'description' => __( 'Enter the draw date for the competition.', 'woocommerce' ) 
        )
    );
    
    echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'win_boo_save_custom_general_fields' );

function win_boo_save_custom_general_fields( $post_id ) {
    $draw_date = $_POST['_draw_date'];
    if ( ! empty( $draw_date ) ) {
        update_post_meta( $post_id, '_draw_date', esc_attr( $draw_date ) );
    }
}


function win_boo_enqueue_scripts() {
    $time = time();
    wp_enqueue_script('jquery');
    wp_enqueue_style('win-boo-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), $time);
    wp_enqueue_script('win-boo-script', plugin_dir_url(__FILE__) . 'assets/js/wooscript.js', array('jquery'), $time, true);
 
    if (is_page_template('custom-homepage-template.php')) {
        wp_enqueue_style('custom-homepage-style', plugin_dir_url(__FILE__) . 'assets/css/custom-homepage.css', array(), $time);
        wp_enqueue_script('custom-homepage-script', plugin_dir_url(__FILE__) . 'assets/js/custom-homepage.js', array('jquery'), $time, true);
    }
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0');
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick.css', array(), '1.5.0');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick-theme.css', array(), '1.5.0');
    wp_enqueue_script('slick-carousel-js', 'https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js', array('jquery'), '1.5.0', true);

    $discount_quantity_15 = get_post_meta(get_the_ID(), '_discount_quantity_15', true);
    $discount_quantity_20 = get_post_meta(get_the_ID(), '_discount_quantity_20', true);
    $discount_quantity_25 = get_post_meta(get_the_ID(), '_discount_quantity_25', true);
    $discount_quantity_50 = get_post_meta(get_the_ID(), '_discount_quantity_50', true);
    $draw_date = get_post_meta(get_the_ID(), '_draw_date', true);

    wp_localize_script('win-boo-script', 'phpVars', array(
        'productId' => get_the_ID(),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'checkoutUrl' => wc_get_checkout_url(),
        'entryPrice' => get_post_meta(get_the_ID(), '_price', true), 
        'discountQuantity15' => $discount_quantity_15,
        'discountQuantity20' => $discount_quantity_20,
        'discountQuantity25' => $discount_quantity_25,
        'discountQuantity50' => $discount_quantity_50,
        'drawDate' => $draw_date, 
    ));
}
add_action('wp_enqueue_scripts', 'win_boo_enqueue_scripts');





function win_boo_custom_template($template) {
    if ( is_singular('product') ) {
        global $post;
            $template = plugin_dir_path(__FILE__) . 'templates/single-product/custom-product-template.php';
    }
    return $template;
}
add_filter('template_include', 'win_boo_custom_template', 99);
function win_boo_add_custom_meta_box() {
    add_meta_box(
        'win_boo_original_price_meta_box',
        __('Original Price', 'win-boo'),
        'win_boo_original_price_meta_box_callback',
        'product',
        'side'
    );
}
add_action('add_meta_boxes', 'win_boo_add_custom_meta_box');

function win_boo_original_price_meta_box_callback($post) {
    $original_price = get_post_meta($post->ID, '_original_price', true);
    echo '<label for="win_boo_original_price">' . __('Original Price', 'win-boo') . '</label>';
    echo '<input type="text" id="win_boo_original_price" name="win_boo_original_price" value="' . esc_attr($original_price) . '" />';
}
function win_boo_save_custom_meta_box($post_id) {
    if (isset($_POST['win_boo_original_price'])) {
        update_post_meta($post_id, '_original_price', sanitize_text_field($_POST['win_boo_original_price']));
    }
}
add_action('save_post', 'win_boo_save_custom_meta_box');






function add_discount_quantity_fields() {
    
    add_action('woocommerce_product_options_general_product_data', 'add_custom_discount_fields2');
    add_action('woocommerce_process_product_meta', 'save_custom_discount_fields2');
}
add_action('admin_init', 'add_discount_quantity_fields');

function add_custom_discount_fields2() {
    echo '<h3 style="margin-left: 10px">Enter Discount Against Each Quantity</h3>';
    woocommerce_wp_text_input(array(
        'id' => '_discount_quantity_15',
        'label' => __('Discount Quantity 15', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter the discount rate for 15 quantities in percentage.', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '0',
        ),
    ));
    woocommerce_wp_text_input(array(
        'id' => '_discount_quantity_20',
        'label' => __('Discount Quantity 20', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter the discount rate for 20 quantities in percentage.', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '0',
        ),
    ));
    woocommerce_wp_text_input(array(
        'id' => '_discount_quantity_25',
        'label' => __('Discount Quantity 25', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter the discount rate for 25 quantities in percentage.', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '0',
        ),
    ));
    woocommerce_wp_text_input(array(
        'id' => '_discount_quantity_50',
        'label' => __('Discount Quantity 50', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter the discount rate for 50 quantities in percentage.', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '0',
        ),
    ));
}

function save_custom_discount_fields2($post_id) {
    $discount_quantity_15 = isset($_POST['_discount_quantity_15']) ? sanitize_text_field($_POST['_discount_quantity_15']) : '';
    $discount_quantity_20 = isset($_POST['_discount_quantity_20']) ? sanitize_text_field($_POST['_discount_quantity_20']) : '';
    $discount_quantity_25 = isset($_POST['_discount_quantity_25']) ? sanitize_text_field($_POST['_discount_quantity_25']) : '';
    $discount_quantity_50 = isset($_POST['_discount_quantity_50']) ? sanitize_text_field($_POST['_discount_quantity_50']) : '';

    update_post_meta($post_id, '_discount_quantity_15', $discount_quantity_15);
    update_post_meta($post_id, '_discount_quantity_20', $discount_quantity_20);
    update_post_meta($post_id, '_discount_quantity_25', $discount_quantity_25);
    update_post_meta($post_id, '_discount_quantity_50', $discount_quantity_50);
}


function add_product_to_cart() {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $total_price = floatval($_POST['total_price']);

    $cart_item_data = array(
        'custom_price' => $total_price / $quantity,
    );

    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);

    if ($cart_item_key) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_add_product_to_cart', 'add_product_to_cart');
add_action('wp_ajax_nopriv_add_product_to_cart', 'add_product_to_cart');

function set_custom_price( $cart_object ) {
    if ( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->get_cart() as $hash => $value ) {
            if( isset( $value['custom_price'] ) ) {
                $value['data']->set_price( $value['custom_price'] );
            }
        }
    }
}
add_action( 'woocommerce_before_calculate_totals', 'set_custom_price', 10, 1 );




function win_boo_register_custom_templates($templates) {
    $templates['custom-homepage-template.php'] = 'Custom Home Page';
    return $templates;
}
add_filter('theme_page_templates', 'win_boo_register_custom_templates');

function win_boo_load_custom_template($template) {
    global $post;
    if ($post && 'custom-homepage-template.php' == get_post_meta($post->ID, '_wp_page_template', true)) {
        $template = plugin_dir_path(__FILE__) . 'custom-homepage-template.php';
    }
    return $template;
}
add_filter('template_include', 'win_boo_load_custom_template');

//register settings start
function win_boo_customize_register($wp_customize) {
    // Add a main panel for the homepage settings
    $wp_customize->add_panel('win_boo_homepage_main_panel', array(
        'title' => __('Homepage Settings', 'win-boo'),
        'description' => __('Customize the homepage sections', 'win-boo'),
        'priority' => 30,
    ));

    // Section 2
    $wp_customize->add_section('win_boo_homepage_section2', array(
        'title' => __('Section 2', 'win-boo'),
        'description' => __('Customize the second section of the homepage', 'win-boo'),
        'panel' => 'win_boo_homepage_main_panel',
        'priority' => 10,
    ));

    $wp_customize->add_setting('win_boo_homepage_section2_bg_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'win_boo_homepage_section2_bg_image_control', array(
        'label' => __('Section 2 Background Image', 'win-boo'),
        'section' => 'win_boo_homepage_section2',
        'settings' => 'win_boo_homepage_section2_bg_image',
        'mime_type' => 'image',
    )));

    $wp_customize->add_setting('win_boo_homepage_section2_title', array(
        'default' => __('UNSERE ZIEL IST ES,<span>JEDEN</span> ZUM <span>GEWINNER</span>ZU MACHEN', 'win-boo'),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('win_boo_homepage_section2_title_control', array(
        'label' => __('Section 2 Title', 'win-boo'),
        'section' => 'win_boo_homepage_section2',
        'settings' => 'win_boo_homepage_section2_title',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('win_boo_homepage_section2_paragraph', array(
        'default' => __('Wir haben Uhren im Wert von 1.395.745 € verschenkt. Weltweit Spitzenreiter für unschlagbare Gewinnchancen.', 'win-boo'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('win_boo_homepage_section2_paragraph_control', array(
        'label' => __('Section 2 Paragraph', 'win-boo'),
        'section' => 'win_boo_homepage_section2',
        'settings' => 'win_boo_homepage_section2_paragraph',
        'type' => 'textarea',
    ));

    // Repeat similar blocks for Section 3, Section 4, etc.
}

add_action('customize_register', 'win_boo_customize_register');



//register setings end

?>
