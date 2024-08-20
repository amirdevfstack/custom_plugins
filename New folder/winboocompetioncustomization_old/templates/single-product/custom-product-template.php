<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

if (!$product || !is_a($product, 'WC_Product')) {
    echo '<p>Sorry, this product is not available.</p>';
    get_footer('shop');
    exit;
}
$entry_price = $product->get_price();
$original_price = get_post_meta($product->get_id(), '_original_price', true);
if (!is_numeric($original_price)) {
    $original_price = 0.00;
} else {
    $original_price = floatval($original_price);
}
$currency_symbol = get_woocommerce_currency_symbol();

$draw_date = get_post_meta($product->get_id(), '_draw_date', true);
get_header('shop');
?>

<div id="countdown-timer"></div>

<div class="step-guide">
    <span class="step">1: Select your ticket</span>
    <span class="separator"> | </span>
    <span class="step">2: Connoisseur challenge</span>
    <span class="separator"> | </span>
    <span class="step">3: Check Out</span>
</div>

<div class="custom-product-layout">
<div class="left-section">
        <div class="product-layout">
            <div class="product-gallery">
                <?php
                // Display the main product image as the first thumbnail
                if (has_post_thumbnail()) {
                    $main_image_url = get_the_post_thumbnail_url($product->get_id(), 'large');
                    $main_image_srcset = wp_get_attachment_image_srcset(get_post_thumbnail_id($product->get_id()), 'thumbnail');
                    echo '<img src="' . esc_url($main_image_url) . '" srcset="' . esc_attr($main_image_srcset) . '" class="product-thumbnail" alt="Product Thumbnail" />';
                }

                // Display additional thumbnails
                $attachment_ids = $product->get_gallery_image_ids();
                foreach ($attachment_ids as $attachment_id) {
                    $thumbnail_url = wp_get_attachment_url($attachment_id);
                    $thumbnail_srcset = wp_get_attachment_image_srcset($attachment_id, 'thumbnail');
                    echo '<img src="' . esc_url($thumbnail_url) . '" srcset="' . esc_attr($thumbnail_srcset) . '" class="product-thumbnail" alt="Product Thumbnail" />';
                }
                ?>
            </div>
            <div class="main-image">
                <?php
                // Display the main product image
                if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail($product->get_id(), 'large', array('class' => 'product-main-image'));
                }
                ?>
            </div>
        </div>
    </div>
    <div class="right-section">
        <h1><?php the_title(); ?></h1>
        <div class="product-info">
            <div class="product-values">
                <span><?php echo esc_html($currency_symbol . number_format($original_price, 2)); ?></span> |
                <span><?php echo esc_html($currency_symbol . number_format($entry_price, 2)); ?></span> |
                <span><?php echo esc_html($draw_date); ?></span>
            </div>
            <div class="product-labels">
                <span>Original Price</span>
                <span>Entry Price</span>
                <span>Draw Date</span>
            </div>
        </div>

        <div class="quantity-selector">
            <?php for ($i = 1; $i <= 10; $i++) {
                echo '<button class="quantity-btn" data-quantity="' . $i . '">' . $i . '</button>';
            } ?>
        </div>

        <div class="vip-pack">
            <button class="vip-btn" data-vip="15" data-discount="10">15 (10% off)</button>
            <button class="vip-btn" data-vip="20" data-discount="15">20 (15% off)</button>
            <button class="vip-btn" data-vip="25" data-discount="20">25 (20% off)</button>
            <button class="vip-btn" data-vip="50" data-discount="25">50 (25% off)</button>
        </div>

        <div class="custom-text">
            <p>Custom text goes here.</p>
        </div>

        <button class="next-step-btn">Continue to the next step -></button>
    </div>
</div>

<div class="product-details">
    <?php echo apply_filters('the_content', $product->get_description()); ?>
</div>

<?php get_footer('shop'); ?>
