<?php
/*
Plugin Name: Strategy Slider
Description: A custom plugin for adding sliders using Swiper.js as an Elementor widget.
Version:     1.0
Author:      Aamir Shahzad
Author URI:  https://alhudasols.com/
License:     GPL2
*/

if (!defined('ABSPATH')) {
    exit; 
}

function enqueue_custom_sliders_assets() {
    wp_enqueue_style('custom-sliders-css', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_style('main-swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');

    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('custom-sliders-js', plugin_dir_url(__FILE__) . 'assets/script.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_sliders_assets');

function register_custom_slider_widget($widgets_manager) {
    require_once(__DIR__ . '/widgets/custom-slider-widget.php');
    $widgets_manager->register(new \Elementor_Custom_Slider_Widget());
}
add_action('elementor/widgets/register', 'register_custom_slider_widget');
