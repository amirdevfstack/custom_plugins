<?php
namespace Elementor;

class Winner_Details_Widget extends Widget_Base {

    public function get_name() {
        return 'winner_details_widget';
    }

    public function get_title() {
        return __('Winner Details', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('UNSERE COMMUNITY HAT GEWONNEN', 'plugin-name'),
                'placeholder' => __('Enter your title', 'plugin-name'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('WIR SIND STOLZ DARAUF, SORGFÄLTIG EINE Uhrenkollektion zusammenzustellen, die Raffinesse und Eleganz verkörpert', 'plugin-name'),
                'placeholder' => __('Enter your subtitle', 'plugin-name'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => 'winner',
            'posts_per_page' => 3,
        );
        $query = new \WP_Query($args);
        ?>
        <div class="custom_main_watch_container custom3rd-boxes-top Page-Width" style="margin-top: 20px;">
            <div class="custom_inner_watch_container Page-Width">
                <div class="Custom-Svg-Box">
                    <div class="Custom-Svg-Title">
                        <div class="Custom-Svg-Title-Inner Custom-Svg-Title1">
                            <h1><?php echo esc_html($settings['title']); ?><br>
                                
                            </h1>
                        </div>
                    </div>
                    <div class="Custom-Svg-Title Custom-Svg-Title1" style="color: #fff;">
                        <p><span><?php echo esc_html($settings['subtitle']); ?></span></p>
                    </div>
                </div>
                <div class="custom_all-box-container">
                    <?php
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();

                            $image = get_post_meta(get_the_ID(), 'winner_image', true);
                            $price = get_post_meta(get_the_ID(), 'watch_price', true);
                            $details = get_post_meta(get_the_ID(), 'winner_details', true);
                            ?>
                            <div class="custom_winuwatch-main-item">
                                <div class="custom_watch_image">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
                                </div>
                                <div class="custom_text_content">
                                    <h3><?php the_title(); ?></h3>
                                    <h4><?php echo esc_html($details); ?></h4>
                                    <p><?php echo esc_html($price); ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
