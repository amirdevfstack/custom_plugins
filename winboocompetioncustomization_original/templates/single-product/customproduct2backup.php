<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

// Fetch the regular price and ensure it is a float
$regular_price = $product->get_regular_price();
if (!is_numeric($regular_price)) {
    $regular_price = 0.00;
} else {
    $regular_price = floatval($regular_price);
}

// Fetch the entry price from the post meta and ensure it is a float
$entry_price = get_post_meta($product->get_id(), '_entry_price', true);
if (!is_numeric($entry_price)) {
    $entry_price = 0.00;
} else {
    $entry_price = floatval($entry_price);
}

// Fetch the currency symbol
$currency_symbol = get_woocommerce_currency_symbol();

// Fetch the draw date
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
                // Display thumbnails
                $attachment_ids = $product->get_gallery_image_ids();
                foreach ( $attachment_ids as $attachment_id ) {
                    $thumbnail_url = wp_get_attachment_url( $attachment_id );
                    $thumbnail_srcset = wp_get_attachment_image_srcset( $attachment_id, 'thumbnail' );
                    echo '<img src="' . esc_url( $thumbnail_url ) . '" srcset="' . esc_attr( $thumbnail_srcset ) . '" class="product-thumbnail" alt="Product Thumbnail" />';
                }
                ?>
            </div>
            <div class="main-image">
                <?php
                // Display the main product image
                if ( has_post_thumbnail() ) {
                    echo get_the_post_thumbnail( $product->get_id(), 'large', array('class' => 'product-main-image') );
                }
                ?>
            </div>
        </div>
    </div>
    <div class="right-section">
        <h1><?php the_title(); ?></h1>
        <div class="product-info">
            <div class="product-values">
                <span><?php echo esc_html($currency_symbol . number_format($regular_price, 2)); ?></span> |
                <span><?php echo esc_html($currency_symbol . number_format($entry_price, 2)); ?></span> |
                <span><?php echo esc_html($draw_date); ?></span>
            </div>
            <div class="product-labels">
                <span>Watch Value</span>
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

<div class="faqs">
    <h2>Frequently Asked Questions</h2>
    <!-- Add your FAQs content here -->
</div>

<?php
if (!empty($draw_date)) {
    // Use MM-DD-YYYY format directly
    echo "
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function parseDate(dateStr) {
            console.log('Parsing date:', dateStr);
            var parts = dateStr.split('-');
            if (parts.length !== 3) {
                console.error('Date format is incorrect');
                return new Date();
            }
            var month = parseInt(parts[0], 10) - 1; // Month is 0-based
            var day = parseInt(parts[1], 10);
            var year = parseInt(parts[2], 10);
            console.log('Parsed date:', year, month, day);
            return new Date(year, month, day);
        }

        var drawDate = parseDate('{$draw_date}').getTime();
    
        console.log('Draw date timestamp:', drawDate);
        var countdownTimer = setInterval(function() {
            var now = new Date().getTime();
            console.log('Current time:', now);
            var distance = drawDate - now;
            if (distance < 0) {
                clearInterval(countdownTimer);
                document.getElementById('countdown-timer').innerHTML = 'The draw has ended';
                return;
            }
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById('countdown-timer').innerHTML = days + 'd ' + hours + 'h ' +
            minutes + 'm ' + seconds + 's ';
        }, 1000);
    });
    </script>
    ";
}
?>

<?php get_footer('shop'); ?>
