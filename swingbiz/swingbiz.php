<?php
/**
 * Plugin Name: Swing Dance School / Business Extensions
 * Plugin URI: https://nathandias.com
 * Description: Custom post types and utilities related to swing dance classes and events
 * Version: 0.1
 * Text Domain: swingbiz
 * Author: Nathan Dias
 * Author URI: https://nathandias.com
 */

require __DIR__ . '/vendor/autoload.php';

include __DIR__ . '/teachers.php';
include __DIR__ . '/bands.php';
// include __DIR__ . '/deejays.php';
// include __DIR__ . '/class_descriptions.php';

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