<?php
namespace Elementor;

class Custom_Blog_Post_Widget extends Widget_Base {

    public function get_name() {
        return 'custom_blog_post';
    }

    public function get_title() {
        return __( 'Custom Blog Post', 'competition-customization' );
    }

    public function get_icon() {
        return 'eicon-posts-ticker';
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
            'posts_per_page',
            [
                'label' => __( 'Posts Per Page', 'competition-customization' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $posts_per_page = $settings['posts_per_page'];
        ?>
        <div class="custom-blog-post-main">
            <div class="custom-blog-post-wrap">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $posts_per_page,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $query = new \WP_Query($args);
                if ($query->have_posts()) :
                    $post_counter = 1;
                    while ($query->have_posts()) : $query->the_post();
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $title = get_the_title();
                        $permalink = get_permalink();
                        $unique_class = "custom-{$post_counter}st-box-blog";
                        $excerpt = wp_trim_words(get_the_excerpt(), 10, '...');
                        ?>
                        <a href="<?php echo esc_url($permalink); ?>" class="<?php echo esc_attr($unique_class); ?>">
                            <div class="custom-blog-image">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($title); ?>">
                            </div>
                            <h1><?php echo esc_html($title); ?></h1>
                            <p><?php echo esc_html($excerpt); ?></p>
                        </a>
                        <?php
                        $post_counter++;
                    endwhile;
                else :
                    echo '<p>No posts found.</p>';
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
    }
}
