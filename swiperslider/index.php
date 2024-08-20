<?php
/**
 * Plugin Name: Simple Swiper Slider
 * Description: A simple plugin to add a Swiper slider with draggable functionality.
 * Version: 1.0
 * Author: Your Name
 */

// Enqueue Swiper.js and CSS
function sss_enqueue_scripts() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('sss-custom-js', plugin_dir_url(__FILE__) . 'swiper-slider.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'sss_enqueue_scripts');

// Shortcode to display the slider
function sss_display_slider() {
    ob_start();
    ?>
    <!-- Swiper HTML -->
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 1">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 2">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 3">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 4">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 5">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 6">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 7">
            </div>
            <div class="swiper-slide">
                <img src="https://navoergonomics.com/wp-content/uploads/2023/09/Navodesk-Electric-Height-Adjustable-Computer-Desk-Bluetooth-Enabled-White-Frame-FrameTop-Desert-Sage-1-1.webp" alt="Desk Image 8">
            </div>
        </div>

        <!-- Add Pagination (optional) -->
        <div class="swiper-pagination"></div>

        <!-- Add Navigation (optional) -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_swiper_slider', 'sss_display_slider');
