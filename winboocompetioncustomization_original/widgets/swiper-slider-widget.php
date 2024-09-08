<?php
class Swiper_Slider_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'swiper_slider_widget';
    }

    public function get_title() {
        return __('Swiper Slider Widget', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-slider-album';
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_image',
            [
                'label' => __('Slide Image', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'slide_text',
            [
                'label' => __('Slide Text', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Slide content goes here', 'plugin-name'),
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slide_text' => __('Slide 1', 'plugin-name'),
                    ],
                    [
                        'slide_text' => __('Slide 2', 'plugin-name'),
                    ],
                ],
                'title_field' => '{{{ slide_text }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="mycustom-swipper-slider Page-Width">
            <div class="custom-top-slider-data">
                <h1 style="font-weight: bold; text-align: center; width: 100%; max-width: 1000px; margin: 0 auto; margin-bottom: 30px;">
                    Warum wir bei der Traumhausverlosung mitmachen
                </h1>
                <div class="cusotm-siwwer-slider-dotted" style="position: absolute; width: 93px; right: 20px; top: 26px;">
                    <div class="swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <div class="swiper-button-prev">
                        <svg style="transform: rotate(180deg);" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($settings['slides'] as $slide) : ?>
                        <div class="swiper-slide">
                            <div class="my-custom-swipper-data">
                                <div class="custom-swipper-slider-image">
                                    <img src="<?php echo esc_url($slide['slide_image']['url']); ?>">
                                </div>
                                <div class="custom-swipper-wrapper-data" style="padding: 20px; text-align: center; font-size: 22px;">
                                    <?php echo esc_html($slide['slide_text']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <# if ( settings.slides.length ) { #>
            <div class="mycustom-swipper-slider Page-Width">
                <div class="custom-top-slider-data">
                    <h1 style="font-weight: bold; text-align: center; width: 100%; max-width: 1000px; margin: 0 auto; margin-bottom: 30px;">
                        Warum wir bei der Traumhausverlosung mitmachen
                    </h1>
                    <div class="cusotm-siwwer-slider-dotted" style="position: absolute; width: 93px; right: 20px; top: 26px;">
                        <div class="swiper-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <div class="swiper-button-prev">
                            <svg style="transform: rotate(180deg);" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <# _.each( settings.slides, function( slide ) { #>
                            <div class="swiper-slide">
                                <div class="my-custom-swipper-data">
                                    <div class="custom-swipper-slider-image">
                                        <img src="{{ slide.slide_image.url }}">
                                    </div>
                                    <div class="custom-swipper-wrapper-data" style="padding: 20px; text-align: center; font-size: 22px;">
                                        {{{ slide.slide_text }}}
                                    </div>
                                </div>
                            </div>
                        <# }); #>
                    </div>
                </div>
            </div>
        <# } #>
        <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Swiper_Slider_Widget());
