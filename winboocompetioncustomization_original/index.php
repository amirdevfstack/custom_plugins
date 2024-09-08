<?php
/*
Plugin Name: Competition Customization Orignal
Description: Customizations for the WooCommerce product details page for win.boo competition.
Version: 1.0
Author: Waseem Ahmad1
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
            'placeholder' => 'M-DD-YYYY',
            'description' => __( 'Enter the draw date for the competition. M-DD-YYYY Follow this format.', 'woocommerce' ) 
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
	 wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '1');
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick.css', array(), '1.5.0');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick-theme.css', array(), '1.5.0');
    wp_enqueue_script('slick-carousel-js', 'https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js', array('jquery'), '1.5.0', true);
	  wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), true);
    $discount_quantity_15 = get_post_meta(get_the_ID(), '_discount_quantity_15', true);
    $discount_quantity_20 = get_post_meta(get_the_ID(), '_discount_quantity_20', true);
    $discount_quantity_25 = get_post_meta(get_the_ID(), '_discount_quantity_25', true);
    $discount_quantity_50 = get_post_meta(get_the_ID(), '_discount_quantity_50', true);
    $draw_date = get_post_meta(get_the_ID(), '_draw_date', true);

   global $product;

    if (empty($product) || !is_a($product, 'WC_Product')) {
        $product = wc_get_product(get_the_ID());
    }
    
    if ($product) {
       
        $total_quantity = get_post_meta($product->get_id(), '_total_tickets', true);
    
      
        if (!$total_quantity) {
            $total_quantity = $product->get_stock_quantity();
        }
    
      
        $current_stock = $product->get_stock_quantity();
    
      
        $sold_quantity = $total_quantity - $current_stock;

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
       'totalQuantity' => $total_quantity,
        'soldQuantity' => $sold_quantity,
    ));
    }
}
add_action('wp_enqueue_scripts', 'win_boo_enqueue_scripts');

function add_total_tickets_custom_field() {
    global $woocommerce, $post;

    echo '<div class="options_group">';

    
    woocommerce_wp_text_input( 
        array( 
            'id'          => '_total_tickets', 
            'label'       => __( 'Total Tickets', 'woocommerce' ), 
            'placeholder' => 'Enter total number of tickets',
            'desc_tip'    => 'true',
            'description' => __( 'This field stores the original total quantity of tickets available.', 'woocommerce' ),
            'type'        => 'number',
            'custom_attributes' => array(
                'min' => '0',
                'step' => '1'
            )
        )
    );

    echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'add_total_tickets_custom_field' );

function save_total_tickets_custom_field( $post_id ) {
    $total_tickets = isset( $_POST['_total_tickets'] ) ? absint( $_POST['_total_tickets'] ) : '';
    update_post_meta( $post_id, '_total_tickets', $total_tickets );
}
add_action( 'woocommerce_process_product_meta', 'save_total_tickets_custom_field' );


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


//slideradmin settings start
function register_winners_cpt() {
    $labels = array(
        'name'               => __('Winners', 'textdomain'),
        'singular_name'      => __('Winner', 'textdomain'),
        'menu_name'          => __('Winners', 'textdomain'),
        'name_admin_bar'     => __('Winner', 'textdomain'),
        'add_new'            => __('Add New', 'textdomain'),
        'add_new_item'       => __('Add New Winner', 'textdomain'),
        'new_item'           => __('New Winner', 'textdomain'),
        'edit_item'          => __('Edit Winner', 'textdomain'),
        'view_item'          => __('View Winner', 'textdomain'),
        'all_items'          => __('All Winners', 'textdomain'),
        'search_items'       => __('Search Winners', 'textdomain'),
        'not_found'          => __('No winners found.', 'textdomain'),
        'not_found_in_trash' => __('No winners found in Trash.', 'textdomain')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'winner'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => array('title'),
    );

    register_post_type('winner', $args);
}
add_action('init', 'register_winners_cpt');

function add_winners_meta_boxes() {
    add_meta_box(
        'winner_details_meta_box',
        __('Winner Details', 'textdomain'),
        'render_winner_details_meta_box',
        'winner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_winners_meta_boxes');

function render_winner_details_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'winner_nonce');
    $winner_stored_meta = get_post_meta($post->ID);

    $image = isset($winner_stored_meta['winner_image'][0]) ? $winner_stored_meta['winner_image'][0] : '';
    $price = isset($winner_stored_meta['watch_price'][0]) ? $winner_stored_meta['watch_price'][0] : '';
    $details = isset($winner_stored_meta['winner_details'][0]) ? $winner_stored_meta['winner_details'][0] : '';

    ?>
    <p>
        <label for="winner_image"><?php _e('Winner Image:', 'textdomain'); ?></label><br>
        <input type="hidden" id="winner_image" name="winner_image" value="<?php echo esc_attr($image); ?>">
        <button class="button" id="winner_image_button"><?php _e('Select Image', 'textdomain'); ?></button>
        <div id="winner_image_preview" style="margin-top: 10px;">
            <?php if ($image): ?>
                <img src="<?php echo esc_url($image); ?>" style="max-width: 200px;">
            <?php endif; ?>
        </div>
    </p>

    <p>
        <label for="watch_price"><?php _e('Watch Price:', 'textdomain'); ?></label><br>
        <input type="text" id="watch_price" name="watch_price" value="<?php echo esc_attr($price); ?>" style="width: 100%;">
    </p>

    <p>
        <label for="winner_details"><?php _e('Details:', 'textdomain'); ?></label><br>
        <textarea id="winner_details" name="winner_details" style="width: 100%; height: 100px;"><?php echo esc_textarea($details); ?></textarea>
    </p>

    <script>
        jQuery(document).ready(function($) {
            $('#winner_image_button').click(function(e) {
                e.preventDefault();
                var image_frame;
                if (image_frame) {
                    image_frame.open();
                }
                // Define image_frame as wp.media object
                image_frame = wp.media({
                    title: 'Select Media',
                    multiple: false,
                    library: {
                        type: 'image',
                    }
                });
                
                image_frame.on('select', function() {
                    var attachment = image_frame.state().get('selection').first().toJSON();
                    $('#winner_image').val(attachment.url);
                    $('#winner_image_preview').html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                });
                image_frame.open();
            });
        });
    </script>
    <?php
}

function save_winner_details($post_id) {
    // Verify nonce
    if (!isset($_POST['winner_nonce']) || !wp_verify_nonce($_POST['winner_nonce'], basename(__FILE__))) {
        return;
    }
    // Save/Update Meta Fields
    update_post_meta($post_id, 'winner_image', sanitize_text_field($_POST['winner_image']));
    update_post_meta($post_id, 'watch_price', sanitize_text_field($_POST['watch_price']));
    update_post_meta($post_id, 'winner_details', sanitize_textarea_field($_POST['winner_details']));
}
add_action('save_post', 'save_winner_details');



function set_custom_winner_columns($columns) {
    unset($columns['date']);
    $columns['winner_image'] = __('Image', 'textdomain');
    $columns['watch_price'] = __('Watch Price', 'textdomain');
    $columns['winner_details'] = __('Details', 'textdomain');
    return $columns;
}
add_filter('manage_winner_posts_columns', 'set_custom_winner_columns');

function custom_winner_column($column, $post_id) {
    switch ($column) {
        case 'winner_image':
            $image = get_post_meta($post_id, 'winner_image', true);
            if ($image) {
                echo '<img src="' . esc_url($image) . '" style="max-width: 100px;">';
            }
            break;
        case 'watch_price':
            $price = get_post_meta($post_id, 'watch_price', true);
            echo esc_html($price);
            break;
        case 'winner_details':
            $details = get_post_meta($post_id, 'winner_details', true);
            echo esc_html(wp_trim_words($details, 15));
            break;
    }
}
add_action('manage_winner_posts_custom_column', 'custom_winner_column', 10, 2);


///slider admin settings end

//Elemntor widgets started
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if Elementor is active
function check_elementor_active() {
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning"><p>Elementor must be installed and activated for this plugin to work.</p></div>';
        });
        return false;
    }
    return true;
}

// Register widget
function register_custom_widget($widgets_manager) {
    require_once(__DIR__ . '/custom-widget.php');
    $widgets_manager->register(new \Elementor\Custom_Widget());
}
add_action('elementor/widgets/register', 'register_custom_widget');

// Enqueue styles and scripts if needed
function enqueue_custom_widget_styles() {
    wp_enqueue_style('custom-widget-style', plugins_url('style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_widget_styles');



add_action( 'elementor/widgets/widgets_registered', function() {
    require_once __DIR__ . '/widgets/competition-section-widget.php';
});


function register_custom_widgets($widgets_manager) {
    require_once(__DIR__ . '/widgets/custom-background-with-image-widget.php');
    $widgets_manager->register(new \Elementor\Custom_Background_With_Image_Widget());

    require_once(__DIR__ . '/widgets/winner-slider-widget.php');
    $widgets_manager->register(new \Elementor\Winner_Slider_Widget());

   
    require_once(__DIR__ . '/widgets/countdown-banner-widget.php');
    $widgets_manager->register(new \Elementor\Countdown_Banner_Widget());


    require_once(__DIR__ . '/widgets/winner-details-widget.php');
    $widgets_manager->register(new \Elementor\Winner_Details_Widget());


    require_once(__DIR__ . '/widgets/draw-certificate-widget.php');
    $widgets_manager->register(new \Elementor\Draw_Certificate_Widget());



    require_once(__DIR__ . '/widgets/swiper-slider-widget.php'); 
    $widgets_manager->register_widget_type(new \Swiper_Slider_Widget());


    require_once( __DIR__ . '/widgets/custom-blog-post-widget.php' );
    $widgets_manager->register( new \Elementor\Custom_Blog_Post_Widget() );


   

}

add_action('elementor/widgets/register', 'register_custom_widgets');



  
?>
