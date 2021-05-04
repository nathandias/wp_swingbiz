<?php

/*
* Creating a function to create our CPT
*/
 
function custom_band_post_type() {
 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Bands', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Band', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Bands', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Band', 'twentytwenty' ),
        'all_items'           => __( 'All Bands', 'twentytwenty' ),
        'view_item'           => __( 'View Band', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Band', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Band', 'twentytwenty' ),
        'update_item'         => __( 'Update Band', 'twentytwenty' ),
        'search_items'        => __( 'Search Band', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
         
    // Set other options for Custom Post Type
         
    $args = array(
        'label'               => __( 'bands', 'twentytwenty' ),
        'description'         => __( 'Band bios and information', 'twentytwenty' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array(),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => 'swingbiz',
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 0,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    
    );
        
    // Registering your Custom Post Type
    register_post_type( 'bands', $args);
     
}
     
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
    
add_action( 'init', 'custom_band_post_type' );

# a shortcode that gets replaced with some static html
function swingbiz_bands_display_all() {
    ob_start();  // start an output buffer - echos and prints will go there

    $args = array( 'post_type' => 'bands', 'posts_per_page' => 10 );
    $the_query = new WP_Query( $args );

    if ($the_query->have_posts()) {
        while ( $the_query->have_posts()) {
            $the_query->the_post();
            echo "<h2>" . the_title() . "</h2>";
            echo the_post_thumbnail('thumbnail');
            echo "<div class='entry-content'>";
            echo the_content();
            echo "</div>";
        }
        wp_reset_postdata();
    } else {
        echo "'Sorry, no posts matched your criteria.";
    }

    return ob_get_clean(); // return the output buffer - shortcodes should return, not echo directly
}

add_shortcode('swingbiz-bands', 'swingbiz_bands_display_all'); // register the new shortcode

function swingbiz_band_display($atts =[], $content=null) {
    ob_start();
    $the_name = $atts['name'];
    echo "<h2>" .  $the_name . "</h2>";
    $results = new WP_Query(array('post_type' => 'band', 'name' => $the_name));

    if ($results->have_posts()) {
        $results->the_post();
        echo "<h2>" . the_title() . "</h2>";
        echo the_post_thumbnail('thumbnail');
        echo "<div class='entry-content'>";
        echo the_content();
        echo "</div>";
        wp_reset_postdata();
    } else {
        echo "<h2>Sorry, couldn't find the band requested.</h2>";
    }   

    return ob_get_clean();
}

add_shortcode('swingbiz-band', 'swingbiz_band_display');