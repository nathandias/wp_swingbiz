<?php

// Our custom post type function
function create_teacher_posttype() {
 
    register_post_type( 'teachers',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Teachers' ),
                'singular_name' => __( 'Teacher' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'teachers'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_teacher_posttype' );

/*
* Creating a function to create our CPT
*/
 
function custom_teacher_post_type() {
 
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Teachers', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Teacher', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Teachers', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Teacher', 'twentytwenty' ),
        'all_items'           => __( 'All Teachers', 'twentytwenty' ),
        'view_item'           => __( 'View Teacher', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Teacher', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Teacher', 'twentytwenty' ),
        'update_item'         => __( 'Update Teacher', 'twentytwenty' ),
        'search_items'        => __( 'Search Teacher', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
         
    // Set other options for Custom Post Type
         
    $args = array(
        'label'               => __( 'teachers', 'twentytwenty' ),
        'description'         => __( 'Teacher bios and information', 'twentytwenty' ),
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
    register_post_type( 'teachers', $args );
     
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
    
add_action( 'init', 'custom_teacher_post_type');

# a shortcode that gets replaced with some static html
function swingbiz_teachers_display_all() {
    ob_start();  // start an output buffer - echos and prints will go there

    $args = array( 'post_type' => 'teachers', 'posts_per_page' => 10 );
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

add_shortcode('swingbiz-teachers', 'swingbiz_teachers_display_all'); // register the new shortcode