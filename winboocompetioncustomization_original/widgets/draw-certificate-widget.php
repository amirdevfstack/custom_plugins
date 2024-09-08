<?php
namespace Elementor;

class Draw_Certificate_Widget extends Widget_Base {

    public function get_name() {
        return 'draw_certificate_widget';
    }

    public function get_title() {
        return __('Draw Certificate', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-image-box';
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
            'image_1',
            [
                'label' => __('Image 1', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'description_1',
            [
                'label' => __('Description 1', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Unser Partner Randomdraws nutzt einen Zufallszahlengenerator eines Drittanbieters für einen unparteiischen und sicheren Auswahlprozess der Gewinner', 'plugin-name'),
                'placeholder' => __('Enter your description', 'plugin-name'),
            ]
        );

        $this->add_control(
            'image_2',
            [
                'label' => __('Image 2', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'title_2',
            [
                'label' => __('Title 2', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Draw certificate example', 'plugin-name'),
                'placeholder' => __('Enter your title', 'plugin-name'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="custom_inner_random_container">
            <div class="custom_all_box_random">
                <div class="custom_box-1_text">
                    <div class="custom_main_all_box-1">
                        <div class="custom_random_image">
                            <img src="<?php echo esc_url($settings['image_1']['url']); ?>" alt="Random Draws Logo">
                        </div>
                        <p><?php echo esc_html($settings['description_1']); ?></p>
                    </div>
                </div>
                <div class="custom_box-2_draw">
                    <div class="custom_main_box-2">
                        <h2><?php echo esc_html($settings['title_2']); ?></h2>
                        <div class="custom_draw-image">
                            <img src="<?php echo esc_url($settings['image_2']['url']); ?>" alt="Random Draws Certificate">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
