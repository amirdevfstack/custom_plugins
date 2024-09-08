<?php
/**
 * Plugin Name: Products and posts filters
 * Description: Adds custom taxonomies for Range, Type, Industry, Pressure, and Power to products.
 * Version: 1.0
 * Author: Aamir Shahzad +923067772024 Whatsapp
 */


 function cpf_enqueue_scripts() {
    wp_enqueue_style('cpf-styles', plugin_dir_url(__FILE__) . 'css/styles.css');
    wp_enqueue_script('cpf-scripts', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);

   
    wp_localize_script('cpf-scripts', 'cpf_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('cpf_ajax_nonce')
    ));
}

add_action('wp_enqueue_scripts', 'cpf_enqueue_scripts');



 function cpt_register_custom_taxonomies() {
     register_taxonomy('range', 'product', array(
         'labels' => array(
             'name' => 'Ranges',
             'singular_name' => 'Range',
             'menu_name' => 'Range',
             'all_items' => 'All Ranges',
             'edit_item' => 'Edit Range',
             'view_item' => 'View Range',
             'update_item' => 'Update Range',
             'add_new_item' => 'Add New Range',
             'new_item_name' => 'New Range Name',
             'parent_item' => 'Parent Range',
             'parent_item_colon' => 'Parent Range:',
             'search_items' => 'Search Ranges',
             'popular_items' => 'Popular Ranges',
             'separate_items_with_commas' => 'Separate ranges with commas',
             'add_or_remove_items' => 'Add or remove ranges',
             'choose_from_most_used' => 'Choose from the most used ranges',
             'not_found' => 'No ranges found.',
         ),
         'hierarchical' => true,
         'show_ui' => true,
         'show_admin_column' => true,
         'query_var' => true,
         'rewrite' => array('slug' => 'range'),
     ));
 
     register_taxonomy('type', 'product', array(
         'labels' => array(
             'name' => 'Types',
             'singular_name' => 'Type',
             'menu_name' => 'Type',
             'all_items' => 'All Types',
             'edit_item' => 'Edit Type',
             'view_item' => 'View Type',
             'update_item' => 'Update Type',
             'add_new_item' => 'Add New Type',
             'new_item_name' => 'New Type Name',
             'parent_item' => 'Parent Type',
             'parent_item_colon' => 'Parent Type:',
             'search_items' => 'Search Types',
             'popular_items' => 'Popular Types',
             'separate_items_with_commas' => 'Separate types with commas',
             'add_or_remove_items' => 'Add or remove types',
             'choose_from_most_used' => 'Choose from the most used types',
             'not_found' => 'No types found.',
         ),
         'hierarchical' => true,
         'show_ui' => true,
         'show_admin_column' => true,
         'query_var' => true,
         'rewrite' => array('slug' => 'type'),
     ));

     register_taxonomy('industry', 'product', array(
         'labels' => array(
             'name' => 'Industries',
             'singular_name' => 'Industry',
             'menu_name' => 'Industry',
             'all_items' => 'All Industries',
             'edit_item' => 'Edit Industry',
             'view_item' => 'View Industry',
             'update_item' => 'Update Industry',
             'add_new_item' => 'Add New Industry',
             'new_item_name' => 'New Industry Name',
             'parent_item' => 'Parent Industry',
             'parent_item_colon' => 'Parent Industry:',
             'search_items' => 'Search Industries',
             'popular_items' => 'Popular Industries',
             'separate_items_with_commas' => 'Separate industries with commas',
             'add_or_remove_items' => 'Add or remove industries',
             'choose_from_most_used' => 'Choose from the most used industries',
             'not_found' => 'No industries found.',
         ),
         'hierarchical' => true,
         'show_ui' => true,
         'show_admin_column' => true,
         'query_var' => true,
         'rewrite' => array('slug' => 'industry'),
     ));
 
     register_taxonomy('pressure', 'product', array(
         'labels' => array(
             'name' => 'Pressures',
             'singular_name' => 'Pressure',
             'menu_name' => 'Pressure',
             'all_items' => 'All Pressures',
             'edit_item' => 'Edit Pressure',
             'view_item' => 'View Pressure',
             'update_item' => 'Update Pressure',
             'add_new_item' => 'Add New Pressure',
             'new_item_name' => 'New Pressure Name',
             'parent_item' => 'Parent Pressure',
             'parent_item_colon' => 'Parent Pressure:',
             'search_items' => 'Search Pressures',
             'popular_items' => 'Popular Pressures',
             'separate_items_with_commas' => 'Separate pressures with commas',
             'add_or_remove_items' => 'Add or remove pressures',
             'choose_from_most_used' => 'Choose from the most used pressures',
             'not_found' => 'No pressures found.',
         ),
         'hierarchical' => true,
         'show_ui' => true,
         'show_admin_column' => true,
         'query_var' => true,
         'rewrite' => array('slug' => 'pressure'),
     ));
 
     register_taxonomy('power', 'product', array(
         'labels' => array(
             'name' => 'Powers',
             'singular_name' => 'Power',
             'menu_name' => 'Power',
             'all_items' => 'All Powers',
             'edit_item' => 'Edit Power',
             'view_item' => 'View Power',
             'update_item' => 'Update Power',
             'add_new_item' => 'Add New Power',
             'new_item_name' => 'New Power Name',
             'parent_item' => 'Parent Power',
             'parent_item_colon' => 'Parent Power:',
             'search_items' => 'Search Powers',
             'popular_items' => 'Popular Powers',
             'separate_items_with_commas' => 'Separate powers with commas',
             'add_or_remove_items' => 'Add or remove powers',
             'choose_from_most_used' => 'Choose from the most used powers',
             'not_found' => 'No powers found.',
         ),
         'hierarchical' => true,
         'show_ui' => true,
         'show_admin_column' => true,
         'query_var' => true,
         'rewrite' => array('slug' => 'power'),
     ));
 }
 
 add_action('init', 'cpt_register_custom_taxonomies');



function cpf_display_filter() {
    ob_start();
    ?>
    <div class="cpf-container">
     
        <div class="cpf-filters">
            <form id="cpf-filter-form">
                <select name="range" id="range">
                    <option value="">Select Range</option>
                    <?php
                    $ranges = get_terms(array('taxonomy' => 'range', 'hide_empty' => false));
                    foreach ($ranges as $term) {
                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <select name="type" id="type">
                    <option value="">Select Type</option>
                    <?php
                    $types = get_terms(array('taxonomy' => 'type', 'hide_empty' => false));
                    foreach ($types as $term) {
                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <select name="industry" id="industry">
                    <option value="">Select Industry</option>
                    <?php
                    $industries = get_terms(array('taxonomy' => 'industry', 'hide_empty' => false));
                    foreach ($industries as $term) {
                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <select name="pressure" id="pressure">
                    <option value="">Select Pressure</option>
                    <?php
                    $pressures = get_terms(array('taxonomy' => 'pressure', 'hide_empty' => false));
                    foreach ($pressures as $term) {
                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <select name="power" id="power">
                    <option value="">Select Power</option>
                    <?php
                    $powers = get_terms(array('taxonomy' => 'power', 'hide_empty' => false));
                    foreach ($powers as $term) {
                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>
            </form>
        </div>

      
        <div id="cpf-results" class="cpf-products">
            <?php cpf_fetch_products(1);  ?>
        </div>

        
        <div class="cpf-bottom-section">
            
            <div class="cpf-sort">
                <select id="sortby">
                    <option value="popularity">Most Popular</option>
                  
                </select>
            </div>

           
            <div class="cpf-pagination">
               
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('custom_product_filter', 'cpf_display_filter');

function cpf_fetch_products($paged = 1, $sortby = 'popularity') {
    $posts_per_page = 3;  

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $sortby == 'popularity' ? 'meta_value_num' : 'date',
        'meta_key' => $sortby == 'popularity' ? 'total_sales' : '',
       
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="cpf-product-list">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';

       
        $total_pages = $query->max_num_pages;
        $visible_pages = 3;  

        if ($total_pages > 1) {
            echo '<div class="cpf-pagination">';

        
            if ($paged > 1) {
                echo '<a href="#" class="cpf-page-link" data-page="' . ($paged - 1) . '">Prev</a>';
            }

            
            $start_page = max(1, $paged - 1);
            $end_page = min($total_pages, $paged + 1);

            
            if ($end_page - $start_page < $visible_pages - 1) {
                if ($start_page == 1) {
                    $end_page = min($total_pages, $start_page + $visible_pages - 1);
                } else if ($end_page == $total_pages) {
                    $start_page = max(1, $end_page - $visible_pages + 1);
                }
            }

            for ($i = $start_page; $i <= $end_page; $i++) {
                if ($i == $paged) {
                    echo '<span class="current-page">' . $i . '</span>';
                } else {
                    echo '<a href="#" class="cpf-page-link" data-page="' . $i . '">' . $i . '</a>';
                }
            }

           
            if ($paged < $total_pages) {
                echo '<a href="#" class="cpf-page-link" data-page="' . ($paged + 1) . '">Next</a>';
            }

            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }

    wp_reset_postdata();
}

function cpf_filter_products() {
    check_ajax_referer('cpf_ajax_nonce', 'security');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $sortby = isset($_POST['sortby']) ? sanitize_text_field($_POST['sortby']) : 'popularity';
    $range = isset($_POST['range']) ? sanitize_text_field($_POST['range']) : '';
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
    $industry = isset($_POST['industry']) ? sanitize_text_field($_POST['industry']) : '';
    $pressure = isset($_POST['pressure']) ? sanitize_text_field($_POST['pressure']) : '';
    $power = isset($_POST['power']) ? sanitize_text_field($_POST['power']) : '';

    $tax_query = array('relation' => 'OR');

    if ($range) {
        $tax_query[] = array(
            'taxonomy' => 'range',
            'field'    => 'slug',
            'terms'    => $range,
        );
    }

    if ($type) {
        $tax_query[] = array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => $type,
        );
    }

    if ($industry) {
        $tax_query[] = array(
            'taxonomy' => 'industry',
            'field'    => 'slug',
            'terms'    => $industry,
        );
    }

    if ($pressure) {
        $tax_query[] = array(
            'taxonomy' => 'pressure',
            'field'    => 'slug',
            'terms'    => $pressure,
        );
    }

    if ($power) {
        $tax_query[] = array(
            'taxonomy' => 'power',
            'field'    => 'slug',
            'terms'    => $power,
        );
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 3,
        'paged' => $paged,
        'orderby' => $sortby == 'popularity' ? 'meta_value_num' : 'date',
        'meta_key' => $sortby == 'popularity' ? 'total_sales' : '',
        'tax_query' => $tax_query,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="cpf-product-list">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';

    
        $total_pages = $query->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="cpf-pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $paged) {
                    echo '<span class="current-page">' . $i . '</span>';
                } else {
                    echo '<a href="#" class="cpf-page-link" data-page="' . $i . '">' . $i . '</a>';
                }
            }
            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }

    wp_reset_postdata();
    wp_die();
}


add_action('wp_ajax_cpf_filter_products', 'cpf_filter_products');
add_action('wp_ajax_nopriv_cpf_filter_products', 'cpf_filter_products');

function news_cpt() {
    $labels = array(
        'name' => 'News',
        'singular_name' => 'News',
        'menu_name' => 'News',
        'name_admin_bar' => 'News',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New News',
        'new_item' => 'New News',
        'edit_item' => 'Edit News',
        'view_item' => 'View News',
        'all_items' => 'All News',
        'search_items' => 'Search News',
        'parent_item_colon' => 'Parent News:',
        'not_found' => 'No News found.',
        'not_found_in_trash' => 'No News found in Trash.'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'news' ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    );
    
    register_post_type( 'news', $args );
}
add_action( 'init', 'news_cpt' );


function register_news_taxonomies() {
    $taxonomies = array(
        'category' => array(
            'label' => 'Categories',
            'singular_label' => 'Category',
            'hierarchical' => true
        ),
        'tags' => array(
            'label' => 'Tags',
            'singular_label' => 'Tag',
            'hierarchical' => false
        ),
        'authors' => array(
            'label' => 'Authors',
            'singular_label' => 'Author',
            'hierarchical' => true
        ),
        'locations' => array(
            'label' => 'Locations',
            'singular_label' => 'Location',
            'hierarchical' => true
        ),
        'topics' => array(
            'label' => 'Topics',
            'singular_label' => 'Topic',
            'hierarchical' => true
        ),
    );

    foreach ( $taxonomies as $taxonomy => $args ) {
        $labels = array(
            'name' => $args['label'],
            'singular_name' => $args['singular_label'],
            'search_items' => 'Search ' . $args['label'],
            'all_items' => 'All ' . $args['label'],
            'parent_item' => $args['hierarchical'] ? 'Parent ' . $args['singular_label'] : '',
            'parent_item_colon' => $args['hierarchical'] ? 'Parent ' . $args['singular_label'] . ':' : '',
            'edit_item' => 'Edit ' . $args['singular_label'],
            'update_item' => 'Update ' . $args['singular_label'],
            'add_new_item' => 'Add New ' . $args['singular_label'],
            'new_item_name' => 'New ' . $args['singular_label'] . ' Name',
            'menu_name' => $args['label'],
        );

        register_taxonomy(
            $taxonomy,
            'news',
            array(
                'hierarchical' => $args['hierarchical'],
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => $taxonomy ),
            )
        );
    }
}
add_action( 'init', 'register_news_taxonomies' );


function news_filter_shortcode() {
    ob_start();
    
    $taxonomies = array('category', 'tags', 'authors', 'locations', 'topics');
    
    echo '<form id="news-filter-form" method="GET" action="' . esc_url(home_url('/')) . '">';
    
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));
        
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<label for="' . esc_attr($taxonomy) . '">' . ucfirst($taxonomy) . ':</label>';
            echo '<select name="' . esc_attr($taxonomy) . '" id="' . esc_attr($taxonomy) . '">';
            echo '<option value="">Select ' . ucfirst($taxonomy) . '</option>';
            
            foreach ($terms as $term) {
                echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
            }
            
            echo '</select>';
        }
    }
    
    echo '<input type="submit" value="Filter">';
    echo '</form>';
    
    echo '<div id="news-results"></div>'; 
    
    return ob_get_clean();
}
add_shortcode('news_filter', 'news_filter_shortcode');


function filter_news_by_taxonomies() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'news',
        'posts_per_page' => 2, 
        'paged' => $paged,
        'post_status' => 'publish',
        'tax_query' => array(
            'relation' => 'OR',
        )
    );

    $taxonomies = array('category', 'tags', 'authors', 'locations', 'topics');
    
    foreach ($taxonomies as $taxonomy) {
        if (isset($_POST[$taxonomy]) && !empty($_POST[$taxonomy])) {
            $args['tax_query'][] = array(
                'taxonomy' => $taxonomy,
                'field'    => 'id',
                'terms'    => intval($_POST[$taxonomy]),
            );
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="news-item">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '<p>' . get_the_excerpt() . '</p>';
            echo '</div>';
        }

        
        $pagination_links = paginate_links(array(
            'total'   => $query->max_num_pages,
            'current' => $paged,
            'format'  => '?paged=%#%',
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'type' => 'array', 
        ));

        if ($pagination_links) {
            echo '<div class="pagination">';
            foreach ($pagination_links as $link) {
               
                $link = preg_replace('/href="([^"]+)"/', 'href="$1" data-page="' . $paged . '"', $link);
                echo '<span class="news-pagination">' . $link . '</span>';
            }
            echo '</div>';
        }
    } else {
        echo '<p>No posts found.</p>';
    }

    wp_reset_postdata();

    wp_die(); 
}

add_action('wp_ajax_filter_news', 'filter_news_by_taxonomies');
add_action('wp_ajax_nopriv_filter_news', 'filter_news_by_taxonomies');


