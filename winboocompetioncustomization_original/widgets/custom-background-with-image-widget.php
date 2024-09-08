<?php
namespace Elementor;

class Custom_Background_With_Image_Widget extends Widget_Base {

    public function get_name() {
        return 'custom_background_with_image';
    }

    public function get_title() {
        return __( 'Custom Background with Image', 'competition-customization' );
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'competition-customization' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'competition-customization' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'UNSERE ZIEL IST ES,<span>JEDEN</span> ZUM <span>GEWINNER</span>ZU MACHEN', 'competition-customization' ),
                'placeholder' => __( 'Type your title here', 'competition-customization' ),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __( 'Text', 'competition-customization' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Wir haben Uhren im Wert von 1.395.745 € verschenkt. Weltweit Spitzenreiter für unschlagbare Gewinnchancen.', 'competition-customization' ),
                'placeholder' => __( 'Type your text here', 'competition-customization' ),
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'competition-customization' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'background_image_size',
            [
                'label' => __( 'Background Image Size', 'competition-customization' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'cover' => __( 'Cover', 'competition-customization' ),
                    'contain' => __( 'Contain', 'competition-customization' ),
                    'auto' => __( 'Auto', 'competition-customization' ),
                ],
                'default' => 'cover',
            ]
        );

        $this->add_control(
            'background_repeat',
            [
                'label' => __( 'Background Repeat', 'competition-customization' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'no-repeat' => __( 'No Repeat', 'competition-customization' ),
                    'repeat' => __( 'Repeat', 'competition-customization' ),
                    'repeat-x' => __( 'Repeat X', 'competition-customization' ),
                    'repeat-y' => __( 'Repeat Y', 'competition-customization' ),
                ],
                'default' => 'no-repeat',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'competition-customization' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .Custom-Svg-Title h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .Custom-Svg-Title p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="Custom-Background-Image Page-Width" style="background-image: url('<?php echo esc_url($settings['background_image']['url']); ?>'); background-size: <?php echo esc_attr($settings['background_image_size']); ?>; background-repeat: <?php echo esc_attr($settings['background_repeat']); ?>;">
            <div class="Custom-Background-Image-Inner">
                <div class="Custom-Svg-Box mycustom-bg-image">
                    <div class="Custom-Svg-Title">
                        <div class="Custom-Svg-Title-Inner">
                            <h1><?php echo $settings['title']; ?></h1>
                        </div>
                    </div>
                    <div class="Custom-Svg-Title">
                        <p><?php echo $settings['text']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <#
        var title = settings.title;
        var text = settings.text;
        var background_image = settings.background_image.url;
        var background_image_size = settings.background_image_size;
        var background_repeat = settings.background_repeat;
        var text_color = settings.text_color;
        #>
        <div class="Custom-Background-Image Page-Width" >
            <div class="Custom-Background-Image-Inner">
                <div class="Custom-Svg-Box mycustom-bg-image" style="background-image: url('{{ background_image }}'); background-size: {{ background_image_size }}; background-repeat: {{ background_repeat }};">
                    <div class="Custom-Svg-Title">
                        <div class="Custom-Svg-Title-Inner">
                            <h1 style="color: {{ text_color }};">{{{ title }}}</h1>
                        </div>
                    </div>
                    <div class="Custom-Svg-Title">
                        <p style="color: {{ text_color }};">{{{ text }}}</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
