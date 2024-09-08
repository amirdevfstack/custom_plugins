<?php
namespace Elementor;

class Winner_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'winner_slider';
    }

    public function get_title() {
        return __( 'Winner Slider', 'competition-customization' );
    }

    public function get_icon() {
        return 'eicon-slider-previous';
    }

    public function get_categories() {
        return [ 'general' ];
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
            'slider_image',
            [
                'label' => __( 'Slider Image', 'competition-customization' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'competition-customization' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'View All Winners', 'competition-customization' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="text Page-Width">
            <div class="slide-flexxx" style="width: 100%; margin: 0 auto;">
                <div class="container">
                    <?php
                    $args = array(
                        'post_type'      => 'winner',
                        'posts_per_page' => -1, 
                    );
                    
                    $query = new \WP_Query($args);
                    
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            
                            // Get custom fields
                            $image = get_post_meta(get_the_ID(), 'winner_image', true);
                            $price = get_post_meta(get_the_ID(), 'watch_price', true);
                            $details = get_post_meta(get_the_ID(), 'winner_details', true);
                    ?>
                    <div class="slide">
                        <div class="custom-slider-wraper">
                            <div class="slide-aaaaa">
                                <img src="<?php echo esc_url($image); ?>" alt="Winner">
                            </div>
                            <div class="slide-aaaaa-text">
                                <div class="pahla-flex" style="display: flex; padding: 20px;">
                                    <div class="flex flex-col justify-center">
                                        <span class="text-xl text-white" style="font-size: 1.25rem; line-height: 1.75rem; color: white;"><?php echo esc_html($details); ?></span>
                                        <br>
                                        <span class="text-base font-medium text-stone-200"><?php echo esc_html(get_the_title()); ?></span>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <span class="text-xl font-medium text-stone-200"><?php echo esc_html($price); ?></span>
                                        <span class="text-stone-200">Value</span>
                                    </div>
                                </div>
                                <div class="qqqq" style="background: black; padding: 20px; display: flex; justify-content: center; align-items: center; gap: 20px; font-weight: 700;">
                                    <span class="text-xl text-white">Join the next competition</span>
                                    <svg viewBox="0 0 24 24" role="image" xmlns="http://www.w3.org/2000/svg" class="mt-1 h-5 w-5">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.858 20H10.221C6.3456 20 4.40789 20 3.20394 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.20394 5.17157C4.40789 4 6.34561 4 10.221 4H12.858C15.0854 4 16.1992 4 17.1289 4.50143C18.0586 5.00286 18.6488 5.92191 19.8294 7.76001L20.5102 8.82001C21.5034 10.3664 22 11.1396 22 12C22 12.8604 21.5034 13.6336 20.5102 15.18L19.8294 16.24C18.6488 18.0781 18.0586 18.9971 17.1289 19.4986C16.1992 20 15.0854 20 12.858 20ZM7 7.05423C7.41421 7.05423 7.75 7.37026 7.75 7.76011V16.2353C7.75 16.6251 7.41421 16.9412 7 16.9412C6.58579 16.9412 6.25 16.6251 6.25 16.2353V7.76011C6.25 7.37026 6.58579 7.05423 7 7.05423Z" fill="white"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                        wp_reset_postdata(); // Reset post data
                    }
                    ?>
                </div>
            </div>
            <div class="buttons">
                <button class="previous">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27px" height="41px">
                        <image x="0px" y="0px" width="27px" height="41px" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAApCAQAAABub5p4AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfoBxoSBjdKAi0zAAAB5klEQVRIx43Wy2sTURTH8e8k0TQKJWhRWyyahU+s1GBtUUHarf4D0pUILnQjooIvCkUXgnQjEUGk4MKFIIUaqKtYQbtoqRB00WoruKoY8IFBkJheF22Sc6YzmfObzTAzH86999xhxnMAePjjxPnq3YMMkOY1k86xcgTFd+cCZf5S4Tu7HU2YymWqq49WuYJnY9fryPGPc8SimcetOnE4Fmm3VBsSlRyLHA+auE6cYVXpM0eC10vnNssCLdAbtsyNJLirKn2iJ7w7jeHdU+gjh5o1tYZGFJoj63sigCW570MH1oxmDfPIKVSkK2DmPraBBwq9Z1/gGiu2jkcKvWNvSGsES/FYoRl2hTW0wVKMKjRNBqJYC08UesMOiGDEySv0NgKBgwwXFSqwncgkuMovgfK0R6MYsIWUuPKCpWiGgywP1Yt4ysQcJJkVcJ6TtBiYg8MKlhgmaWFwjA8C/uFGUyg2Vz8LApa5RMLC4ASvBPzBeeIWBtt4JuA3ztgYbGVcwK8M2hh0UhDwC6dJWxhkmBLwJznaLAz2UBSwQo5WC4Nu1ccqI2y0MOhmQlW8I2DTb8Bmnqqdc431FgZtjKl29NkYdPBSwLNWBjuZrA/zqJ3Bfp5TYombtc3thf2X+LKJLL+ZrlX4D+vYhNmVPTwHAAAAAElFTkSuQmCC" />
                    </svg>
                </button>
                <button class="next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27px" height="41px">
                        <image x="0px" y="0px" width="27px" height="41px" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAApCAQAAABub5p4AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfoBxoSBjdKAi0zAAAB5klEQVRIx43Wy2sTURTH8e8k0TQKJWhRWyyahU+s1GBtUUHarf4D0pUILnQjooIvCkUXgnQjEUGk4MKFIIUaqKtYQbtoqRB00WoruKoY8IFBkJheF22Sc6YzmfObzTAzH86999xhxnMAePjjxPnq3YMMkOY1k86xcgTFd+cCZf5S4Tu7HU2YymWqq49WuYJnY9fryPGPc8SimcetOnE4Fmm3VBsSlRyLHA+auE6cYVXpM0eC10vnNssCLdAbtsyNJLirKn2iJ7w7jeHdU+gjh5o1tYZGFJoj63sigCW570MH1oxmDfPIKVSkK2DmPraBBwq9Z1/gGiu2jkcKvWNvSGsES/FYoRl2hTW0wVKMKjRNBqJYC08UesMOiGDEySv0NgKBgwwXFSqwncgkuMovgfK0R6MYsIWUuPKCpWiGgywP1Yt4ysQcJJkVcJ6TtBiYg8MKlhgmaWFwjA8C/uFGUyg2Vz8LApa5RMLC4ASvBPzBeeIWBtt4JuA3ztgYbGVcwK8M2hh0UhDwC6dJWxhkmBLwJznaLAz2UBSwQo5WC4Nu1ccqI2y0MOhmQlW8I2DTb8Bmnqqdc431FgZtjKl29NkYdPBSwLNWBjuZrA/zqJ3Bfp5TYombtc3thf2X+LKJLL+ZrlX4D+vYhNmVPTwHAAAAAElFTkSuQmCC" />
                    </svg>
                </button>
            </div>
        </div>
        <?php
    }
}

