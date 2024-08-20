<?php
/**
 * Plugin Name: State App Manager
 * Description: Manages States and Apps Listing Dropdown.
 * Version: 1.0
 * Author: Aamir Shahzad jamamir103@gmail.com
 */

// Hook into the 'init' action
add_action('init', 'register_custom_post_types');

function register_custom_post_types() {
    // Register the 'Apps' Custom Post Type
    register_post_type('apps', array(
        'labels' => array(
            'name' => __('Apps'),
            'singular_name' => __('App')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'apps'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'), // Added 'custom-fields'
        'show_in_rest' => true  // Enables Gutenberg editor
    ));
    
}
function enqueue_custom_styles() {
    // Use plugin_dir_url(__FILE__) to get the correct URL to your plugin directory
    wp_enqueue_style('custom-style', plugin_dir_url(__FILE__) . 'style.css');
}

// Hook the above function into WordPress 'wp_enqueue_scripts' action
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


add_action('init', 'create_states_taxonomy');

function create_states_taxonomy() {
    register_taxonomy(
        'state',  // Taxonomy name
        'apps',   // Post type name
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('States', 'taxonomy general name'),
                'singular_name' => _x('State', 'taxonomy singular name')
            ),
            'show_ui' => true,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'state'),
        )
    );

    // Optionally pre-populate the taxonomy with all US states if not already added
    $states = ["Alabama", "Alaska", "Arizona", /* Add all states here */ "Wyoming"];
    foreach ($states as $state) {
        if (!term_exists($state, 'state')) {
            wp_insert_term($state, 'state');
        }
    }
}

add_shortcode('state_apps_dropdown', 'render_state_apps_dropdown');

function render_state_apps_dropdown() {
    $terms = get_terms(['taxonomy' => 'state', 'hide_empty' => false]);
    $output = '<div class="container-fluid col-lg-10 col-md-12 col-sm-12 col-12 mt-5">';
    $output .= '<select class="form-select form-select-lg" id="statesDropdown" aria-label=".form-select-lg example">';
    $output .= '<option selected>Select your State</option>';
    foreach ($terms as $term) {
        $output .= '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
    }
    $output .= '</select></div>';

    $output .= '<div id="appsList" class="container-fluid col-lg-5 col-md-7 col-sm-9 col-12 mt-5"></div>';

    $output .= '<script type="text/javascript">
        document.getElementById("statesDropdown").addEventListener("change", function() {
            var selectedState = this.options[this.selectedIndex].text;
            fetch("' . admin_url('admin-ajax.php') . '?action=fetch_apps_by_state&state_id=" + this.value)
                .then(response => response.json())
                .then(data => {
                    var apps = data.apps;
                    var listHtml = "";
                    apps.forEach(function(app, index) {
                        listHtml += \'<div class="card-body pb-4 px-2 pt-2 mb-5">\' +
                            \'<h3 class="card-title fw-bold">#\' + (index + 1) + \'</h3>\' + // Card index
                            \'<h4 class="text-center fw-bold">\' + app.name + \'</h4>\' + // Title
                            \'<img src="\' + app.image_url + \'" class="mx-auto d-block mb-4" alt="Featured Image" style="width:100%;">\' + // Featured image
                            \'<img src="\' + app.rating_stars_url + \'" class="mx-auto d-block mb-3" alt="Rating Stars" style="width: 100px;">\' + // Rating stars image
                            \'<p class="text-center">\' + app.description + \'</p>\' + // Description
                            \'<h5 class="text-center">Available in \' + selectedState + \'</h5>\' + // Availability
                            \'<div class="d-flex justify-content-center mt-2">\'+
                                \'<a href="\' + app.button_url + \'" class="btn btn-primary text-decoration-none text-white">BET NOW</a>\' + // Button
                            \'</div>\' +
                        \'</div>\';
                    });
                    document.getElementById("appsList").innerHTML = listHtml;
                });
        });
    </script>';

    return $output;
}





add_action('wp_ajax_fetch_apps_by_state', 'fetch_apps_by_state');
add_action('wp_ajax_nopriv_fetch_apps_by_state', 'fetch_apps_by_state');

function fetch_apps_by_state() {
    $state_id = intval($_GET['state_id']);
    $apps = get_posts(array(
        'post_type' => 'apps',
        'numberposts' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'state',
                'field' => 'term_id',
                'terms' => $state_id,
            ),
        ),
    ));

    $response = array();
    foreach ($apps as $app) {
        $app_data = array(
            'name' => $app->post_title,
            'description' => $app->post_content,
            'button_url' => get_post_meta($app->ID, 'button_url', true),
            'image_url' => get_the_post_thumbnail_url($app->ID, 'full'), // Ensure you fetch the full image size
            'rating_stars_url' => get_post_meta($app->ID, 'rating_stars_url', true) // Custom field for rating stars
        );
        $response[] = $app_data;
    }

    wp_send_json(array('apps' => $response));
}







add_action('add_meta_boxes', 'add_custom_meta_boxes');

add_action('save_post', 'save_custom_meta_box_data');

function add_custom_meta_boxes() {
    add_meta_box(
        'app_details_meta_box', // ID of the meta box
        'App Details', // Title of the meta box
        'display_app_details_meta_box', // Callback function to display the meta box
        'apps', // Post type
        'normal', // Context where the box will appear
        'high' // Priority of the box
    );
}

function display_app_details_meta_box($post) {
    // Nonce field for security
    wp_nonce_field(basename(__FILE__), 'app_details_nonce');

    // Get existing values
    $button_label = get_post_meta($post->ID, 'button_label', true);
    $button_url = get_post_meta($post->ID, 'button_url', true);
    $rating_stars = get_post_meta($post->ID, 'rating_stars_url', true);

    // Display the form, using the current value.
    ?>
    <p>
        <label for="button_label">Button Label:</label>
        <input type="text" name="button_label" id="button_label" value="<?php echo esc_attr($button_label); ?>" class="widefat">
    </p>
    <p>
        <label for="button_url">Button URL:</label>
        <input type="url" name="button_url" id="button_url" value="<?php echo esc_url($button_url); ?>" class="widefat">
    </p>
    <p>
        <label for="rating_stars_url">Rating Stars Image URL:</label>
        <input type="url" name="rating_stars_url" id="rating_stars_url" value="<?php echo esc_url($rating_stars); ?>" class="widefat">
    </p>
    <?php
}

function save_custom_meta_box_data($post_id) {
    
    if (!isset($_POST['app_details_nonce']) || !wp_verify_nonce($_POST['app_details_nonce'], basename(__FILE__))) {
        return;
    }

   
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

   
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'button_label', sanitize_text_field($_POST['button_label']));
    update_post_meta($post_id, 'button_url', esc_url_raw($_POST['button_url']));
    update_post_meta($post_id, 'rating_stars_url', esc_url_raw($_POST['rating_stars_url']));  // Save the image URL for the rating stars
}













?>
