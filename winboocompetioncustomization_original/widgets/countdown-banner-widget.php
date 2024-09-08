<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Countdown_Banner_Widget extends Widget_Base {

    public function get_name() {
        return 'countdown_banner_widget';
    }

    public function get_title() {
        return __('Countdown Banner', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-countdown';
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
            'heading_text',
            [
                'label' => __('Heading', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Next Competition', 'plugin-name'),
                'placeholder' => __('Enter heading text', 'plugin-name'),
            ]
        );

        $this->add_control(
            'subheading_text',
            [
                'label' => __('Subheading', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Hurry! Offers end soon.', 'plugin-name'),
                'placeholder' => __('Enter subheading text', 'plugin-name'),
            ]
        );

        $this->add_control(
            'competition_date',
            [
                'label' => __('Competition Date', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'enableTime' => true,
                    'time_24hr' => true,
                ],
                'default' => '',
                'description' => __('Set the date and time for the next competition.', 'plugin-name'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Competition', 'plugin-name'),
                'placeholder' => __('Enter button text', 'plugin-name'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'plugin-name'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $competition_date = $settings['competition_date'];
        ?>
        <div class="custom-countdown-banner--main" data-date="<?php echo esc_attr($competition_date); ?>">
            <div class="custom-countdown-banner--main-wrap Page-Width">
                <div class="custom-countdown-banner-data">
                    <div class="custom-countdown-banner-data-wrap">
                        <h1><?php echo $settings['heading_text']; ?></h1>
                        <p><?php echo $settings['subheading_text']; ?></p>
                        <div id="countdown">
                            <div>
                                <span id="days">0</span>
                                <p>Days</p>
                            </div>
                            <div>
                                <span id="hours">0</span>
                                <p>Hours</p>
                            </div>
                            <div>
                                <span id="minutes">0</span>
                                <p>Minutes</p>
                            </div>
                            <div>
                                <span id="seconds">0</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <div class="custom-product-sale-btn">
                            <a href="<?php echo esc_url($settings['button_link']['url']); ?>">
                                <?php echo $settings['button_text']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <#
        var settings = settings;
        #>
        <div class="custom-countdown-banner--main" data-date="{{ settings.competition_date }}">
            <div class="custom-countdown-banner--main-wrap Page-Width">
                <div class="custom-countdown-banner-data">
                    <div class="custom-countdown-banner-data-wrap">
                        <h1>{{{ settings.heading_text }}}</h1>
                        <p>{{{ settings.subheading_text }}}</p>
                        <div id="countdown">
                            <div>
                                <span id="days">0</span>
                                <p>Days</p>
                            </div>
                            <div>
                                <span id="hours">0</span>
                                <p>Hours</p>
                            </div>
                            <div>
                                <span id="minutes">0</span>
                                <p>Minutes</p>
                            </div>
                            <div>
                                <span id="seconds">0</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <div class="custom-product-sale-btn">
                            <a href="{{ settings.button_link.url }}">
                                {{{ settings.button_text }}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
