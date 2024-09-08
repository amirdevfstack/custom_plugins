<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Competition_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'competition_section_widget';
    }

    public function get_title() {
        return __('Competition Section', 'competition-customization');
    }

    public function get_icon() {
        return 'eicon-posts-grid'; // You can use any Elementor icon here
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {

        // Section for Title Styling
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'competition-customization'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'competition-customization'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .Custom-Rolex-Title h1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_font_size',
            [
                'label' => __('Title Font Size', 'competition-customization'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .Custom-Rolex-Title h1' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Additional controls for other elements can be added here

        $this->end_controls_section();
    }

    protected function render() {
        // Query for latest products
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 3,
            'meta_key' => '_draw_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );

        $products = new WP_Query($args);

        if ($products->have_posts()) :
            echo '<div class="Custom-Rolex-Main top_product_section">';
            echo '<div class="Custom-Rolex-Inner Page-Width">';
            echo '<div class="Custom-Rolex-Boxes">';

            while ($products->have_posts()) : $products->the_post();
                global $product;
                $entry_price = $product->get_price();
                $original_price = get_post_meta($product->get_id(), '_original_price', true);
                $original_price = is_numeric($original_price) ? floatval($original_price) : 0.00;
                $currency_symbol = get_woocommerce_currency_symbol();
                $stock_quantity = $product->get_stock_quantity();
                $main_image_url = get_the_post_thumbnail_url($product->get_id(), 'large');
                $draw_date = get_post_meta($product->get_id(), '_draw_date', true);

                if (preg_match('/(\d{2})-(\d{2})-(\d{4})/', $draw_date, $matches)) {
                    $draw_date_formatted = $matches[3] . '-' . $matches[1] . '-' . $matches[2];
                    $draw_date_timestamp = strtotime($draw_date_formatted);
                } else {
                    $draw_date_timestamp = false;
                }

                $draw_day = $draw_date_timestamp ? date('D j M', $draw_date_timestamp) : 'Invalid date';

                ?>
                <div class="Custom-Rolex-Box">
                    <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <div class="Custom-Rolex-Data">
                        <div class="Custom-Rolex-Title">
                            <h3 style="color:white;"><mark style="background-color: #DAA521; color: #fff;">Draw <?php echo esc_html($draw_day); ?></mark></h3>
                            <h1><?php the_title(); ?></h1>
                            <h2><?php echo esc_html($currency_symbol . number_format($original_price, 2)); ?></h2>
                        </div>
                        <div class="Custom-Rolex-Count-Box">
                            <div class="Custom-Rolex-Count">
                                <div class="countdown" data-draw-date="<?php echo esc_attr($draw_date); ?>" id="countdown-<?php echo get_the_ID(); ?>">
                                    <div class="countdown-item">
                                        <span class="days">00</span>
                                        <div class="label">DAY</div>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="hours">00</span>
                                        <div class="label">HOUR</div>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="minutes">00</span>
                                        <div class="label">MIN</div>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="seconds">00</span>
                                        <div class="label">SEC</div>
                                    </div>
                                </div>
                            </div>
                            <div class="Custom-Rolex-Count">
                                <div class="Custom-Watch-Data">
                                    <div class="Custom-Watch-Data-Inner">
                                        <h1>Uhren Wert</h1>
                                        <p><?php echo esc_html($currency_symbol . number_format($original_price, 2)); ?></p>
                                    </div>
                                </div>
                                <div class="Custom-Watch-Data">
                                    <div class="Custom-Watch-Data-Inner">
                                        <h1>Eintrittspreis</h1>
                                        <p><?php echo esc_html($currency_symbol . number_format($entry_price, 2)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Custom-Button-Data">
                            <div class="Custom-Text-Data">
                                <h1><?php echo esc_html($stock_quantity); ?></h1>
                                <h2>MAXIMUM TICKETS</h2>
                            </div>
                            <div class="Custom-Text-Data">
                                <a href="<?php the_permalink(); ?>">Sichere dir dein Ticket →</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;

            echo '</div>';
            echo '</div>';
            echo '</div>';

            wp_reset_postdata();
        endif;
    }

    protected function _content_template() {
        // This is the live preview template
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Competition_Section_Widget() );
