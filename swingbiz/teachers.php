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
add_action( 'init', 'create__teacher_posttype' );

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
            'taxonomies'          => array( 'class-subjects' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
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
     
    add_action( 'init', 'custom_teacher_post_type', 0 );