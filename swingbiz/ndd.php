<?php
/**
 * Plugin Name: Nathan's Plugin
 * Plugin URI: https://nathandias.com
 * Description: Plugin development experiments
 * Version: 0.1
 * Text Domain: ndd
 * Author: Nathan Dias
 * Author URI: https://nathandias.com
 */
 

# a shortcode that gets replaced with some static html
function ndd_shortcode_callback() {
    ob_start();  // start an output buffer - echos and prints will go there
    echo "<h1>Here's some text to add to the post</h1>\n";
    echo "<p>I don't understand why you work now, but didn't work earlier.</p>\n";
    return ob_get_clean(); // return the output buffer - shortcodes should return, not echo directly
}

add_shortcode('ndd-display', 'ndd_shortcode_callback'); // register the new shortcode


require __DIR__ . '/vendor/autoload.php';

function ndd_load_carbon_fields() {
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'ndd_load_carbon_fields' );

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function ndd_add_plugin_settings_page() {
    Container::make( 'theme_options', __( 'NDD Plugin Page' ) )
        ->set_page_parent( 'options-general.php' )
        ->add_fields( array(
            Field::make( 'text', 'ndd_api_key', 'API Key' )
                ->set_attribute( maxLength, 32 ),
            Field::make( 'text', 'ndd_results_limit', 'Results Limit' )
                ->set_attribute( 'min', 1 )
                ->set_attribute( 'max', 100 )
                ->set_default_value( 10 ),
            Field::make( 'date', 'ndd_start_date', 'Start Date' ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'ndd_add_plugin_settings_page' );

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



