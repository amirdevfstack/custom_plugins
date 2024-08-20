<?php

namespace Elementor;

class Custom_Widget extends Widget_Base {

    public function get_name() {
        return 'custom_image_with_text';
    }

    public function get_title() {
        return __('Custom Image with Text', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-image-bold';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        // Image control
        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
    
        // Title control
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Default Title', 'plugin-name'),
            ]
        );
    
        // Description control
        $this->add_control(
            'description',
            [
                'label' => __('Description', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default description', 'plugin-name'),
            ]
        );
    
        $this->end_controls_section();
    
        // Style section for title
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Title Style', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Title color
        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h1' => 'color: {{VALUE}}',
                ],
            ]
        );
    
        // Title font size
        $this->add_control(
            'title_font_size',
            [
                'label' => __('Font Size', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} h1' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    
        // Style section for image
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Image Style', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
    
        // Image width
        $this->add_control(
            'image_width',
            [
                'label' => __('Image Width', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    

    protected function render() {
        $settings = $this->get_settings_for_display();

        echo '<div class="custom-image-width-text-main" style="margin: 20px 0px;">';
        echo '   <div class="custom-image-width-text-main-wrap Page-Width">';
        echo '      <div class="custom-image-width-text-main-data">';
        echo '         <div class="custom-image-width-text-main-data-left">';
        echo '            <div class="custom-left-image-wrap">';
        echo '               <img src="' . esc_url($settings['image']['url']) . '">';
        echo '            </div>';
        echo '         </div>';
        echo '         <div class="custom-image-width-text-main-data-right">';
        echo '            <div class="custom-right-data-wrapper">';
        echo '               <h1>' . esc_html($settings['title']) . '</h1>';
        echo '               <p>' . esc_html($settings['description']) . '</p>';
        echo '            </div>';
        echo '         </div>';
        echo '      </div>';
        echo '   </div>';
        echo '</div>';
    }
}






