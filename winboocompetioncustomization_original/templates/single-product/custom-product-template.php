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
    <span class="step">1. Select your ticket</span>
    <span class="step">2. Check Out</span>
</div>

<div class="custom-product-layout">
	<div class="custom-product-layout-wrap">
<div class="left-section">
        <div class="product-layout">
            <div class="product-gallery">
                <?php
                if (has_post_thumbnail()) {
                    $main_image_url = get_the_post_thumbnail_url($product->get_id(), 'large');
                    $main_image_srcset = wp_get_attachment_image_srcset(get_post_thumbnail_id($product->get_id()), 'thumbnail');
                    echo '<img src="' . esc_url($main_image_url) . '" srcset="' . esc_attr($main_image_srcset) . '" class="product-thumbnail" alt="Product Thumbnail" />';
                }
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
                if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail($product->get_id(), 'large', array('class' => 'product-main-image'));
                }
                ?>
            </div>
        </div>
    </div>
    <div class="right-section">
		 <div class="right-section-wrap">
        <h1><?php the_title(); ?></h1>
        <div class="product-info">
            <div class="product-values">
				<span><?php echo esc_html($currency_symbol . number_format($original_price, 2)); ?><h5 style="color: #7A7A7A;font-size: 14px;">Original Price</h5></span> 
                <span><?php echo esc_html($currency_symbol . number_format($entry_price, 2)); ?><h5 style="color: #7A7A7A;font-size: 14px;">Entry Price</h5></span> 
                <span><?php echo esc_html($draw_date); ?><h5 style="color: #7A7A7A;font-size: 14px;">Draw Date</h5></span>
            </div>

        </div>

        <div class="quantity-selector">
            <?php for ($i = 1; $i <= 10; $i++) {
                echo '<button class="quantity-btn" data-quantity="' . $i . '">' . $i . '</button>';
            } ?>
        </div>

        <div class="vip-pack">
            <button class="vip-btn" data-vip="15" data-discount="10"><span style="font-weight: bold;">15</span><br> <span class="custom-discount">(10% off)</span><br><span class="chance-to-win">1/60 chance to win</span></button>
            <button class="vip-btn" data-vip="20" data-discount="15"><span style="font-weight: bold;">20</span><br> <span class="custom-discount">(15% off)</span><br><span class="chance-to-win">1/45 chance to win</span></button>
            <button class="vip-btn" data-vip="25" data-discount="20"><span style="font-weight: bold;">25</span><br> <span class="custom-discount">(20% off)</span><br><span class="chance-to-win">1/36 chance to win</span></button>
            <button class="vip-btn" data-vip="50" data-discount="25"><span style="font-weight: bold;">50</span><br> <span class="custom-discount">(25% off)</span><br><span class="chance-to-win">1/18 chance to win</span></button>
        </div>

           <div class="progress-container">
            <div class="progress-info">
                <div class="tickets-sold">
                    <img src="https://win.boo/wp-content/uploads/2024/07/ticket-removebg-preview1.png" style="width: 18px; margin-right: 4px;">Tickets sold: <span id="tickets-sold-count" style="margin: 0px 4px;">2319</span> (of) <span style="margin: 0px 4px;" id="total-tickets">9999</span>
                </div>
                <div class="sold-percentage">
                    <span id="sold-percentage">23%</span> sold
                </div>
            </div>
            <div class="progress-bar-wrapper" style="background: none;">
                <div class="progress-bar">
                    <div class="progress-bar-fill"></div>
                </div>
            </div>
        </div>

        <button class="next-step-btn" style="background-color:#DAA521;">Add to cart</button>
		</div>
    </div>
	</div>
</div>

<div class="product-details">
    <?php // echo apply_filters('the_content', $product->get_description()); ?>
</div>

<?php get_footer('shop'); ?>
