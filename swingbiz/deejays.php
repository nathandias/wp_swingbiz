<?php

// Our custom post type function
function create_deejay_posttype() {
 
    register_post_type( 'deejays',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Deejays' ),
                'singular_name' => __( 'Deejay' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'deejays'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_deejay_posttype' );

/*
* Creating a function to create our CPT
*/
 
function custom_deejay_post_type() {
 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Deejays', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Deejay', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Deejays', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Deejay', 'twentytwenty' ),
        'all_items'           => __( 'All Deejays', 'twentytwenty' ),
        'view_item'           => __( 'View Deejay', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Deejay', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Deejay', 'twentytwenty' ),
        'update_item'         => __( 'Update Deejay', 'twentytwenty' ),
        'search_items'        => __( 'Search Deejay', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
         
    // Set other options for Custom Post Type
         
    $args = array(
        'label'               => __( 'deejays', 'twentytwenty' ),
        'description'         => __( 'Deejay bios and information', 'twentytwenty' ),
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
    register_post_type( 'deejays', $args );
     
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
    
add_action( 'init', 'custom_deejay_post_type');

# a shortcode that displays all the deejays in alpabetical order
function swingbiz_deejays_display_all() {
    ob_start();  // start an output buffer - echos and prints will go there

    $args = array( 'post_type' => 'deejays', 'posts_per_page' => 10 );
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

add_shortcode('swingbiz-deejays', 'swingbiz_deejays_display_all'); // register the new shortcode


function swingbiz_deejay_display($atts =[], $content=null) {
    ob_start();
    $the_name = $atts['name'];
    echo "<h2>" .  $the_name . "</h2>";
    $results = new WP_Query(array('post_type' => 'deejays', 'name' => $the_name));

    if ($results->have_posts()) {
        $results->the_post();
        echo "<h2>" . the_title() . "</h2>";
        echo the_post_thumbnail('thumbnail');
        echo "<div class='entry-content'>";
        echo the_content();
        echo "</div>";
        wp_reset_postdata();
    } else {
        echo "<h2>Sorry, couldn't find the deejay requested.</h2>";
    }   

    return ob_get_clean();
}

add_shortcode('swingbiz-deejay', 'swingbiz_deejay_display');