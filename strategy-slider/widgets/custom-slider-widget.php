<?php
if (!defined('ABSPATH')) {
    exit; 
}

class Elementor_Custom_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'strategy_slider';
    }

    public function get_title() {
        return __('Strategy Slider', 'custom-sliders');
    }

    public function get_icon() {
        return 'eicon-slider-full-screen';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Slides', 'custom-sliders'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_title',
            [
                'label' => __('Slide Title', 'custom-sliders'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Slide Title', 'custom-sliders'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_content',
            [
                'label' => __('Slide Content', 'custom-sliders'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Slide content here.', 'custom-sliders'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_image',
            [
                'label' => __('Slide Image', 'custom-sliders'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
            'slide_link',
            [
                'label' => __('Slide Link', 'custom-sliders'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'custom-sliders'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'custom-sliders'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slide_title' => __('Slide #1', 'custom-sliders'),
                        'slide_content' => __('Slide content here.', 'custom-sliders'),
                    ],
                ],
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="custom-wrapper-main" >
        <div class="custom-wrapper-main-wrap" style="position: absolute; background-position: center center; background-size: cover; background-repeat: no-repeat; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;background-image: url('https://auxa.xpressbuddy.com/wp-content/uploads/2024/03/srv-bg.jpg');">

</div>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach ( $settings['slides'] as $slide ) : ?>
                        <div class="swiper-slide">
                            <div class="swiper-slide-wrap">
                                <div class="swiper-slide-wrap-inner">
                                    <h2 class="xb-item--title">
                                        <a href="<?php echo esc_url( $slide['slide_link']['url'] ); ?>">
                                            <?php echo esc_html( $slide['slide_title'] ); ?>
                                        </a>
                                    </h2>
                                    <div class="xb-item--content">
                                        <?php echo esc_html( $slide['slide_content'] ); ?>
                                    </div>
                                    <div class="xb-item--image">
                                        <img src="<?php echo esc_url( $slide['slide_image']['url'] ); ?>" alt="">
                                    </div>
                                    <div class="xb-item--srv_link">
                                        <a href="<?php echo esc_url( $slide['slide_link']['url'] ); ?>">
                                            Learn More
                                        </a>
                                    </div>
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
        <#
        var slides = settings.slides;
        #>
        <div class="custom-wrapper-main">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <# _.each( slides, function( slide ) { #>
                        <div class="swiper-slide">
                            <div class="swiper-slide-wrap">
                                <div class="swiper-slide-wrap-inner">
                                    <h2 class="xb-item--title">
                                        <a href="{{ slide.slide_link.url }}">
                                            {{{ slide.slide_title }}}
                                        </a>
                                    </h2>
                                    <div class="xb-item--content">
                                        {{{ slide.slide_content }}}
                                    </div>
                                    <div class="xb-item--image">
                                        <img src="{{ slide.slide_image.url }}" alt="">
                                    </div>
                                    <div class="xb-item--srv_link">
                                        <a href="{{ slide.slide_link.url }}">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <# }); #>
                </div>
            </div>
        </div>
        <?php
    }
}
