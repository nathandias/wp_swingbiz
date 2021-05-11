<?php

// add the plugin settings page to the admin menu under "settings"
function swingbiz_add_settings_page() {
    add_options_page( 'SwingBiz plugin options',
        'SwingBiz Plugin Menu',
        'manage_options',
        'swingbiz-plugin',
        'swingbiz_render_plugin_settings_page' );
}
add_action( 'admin_menu', 'swingbiz_add_settings_page' );


// display the settings page form
function swingbiz_render_plugin_settings_page() {

    echo "<h2>Example Plugin Settings</h2>";
    echo '<form action="options.php" method="post">';
    settings_fields( 'swingbiz_plugin_options' );
    do_settings_sections( 'swingbiz_plugin' );
    
    echo '<input name="submit" class="button button-primary" type="submit" value="' . esc_attr('Save') . '" />';

    echo '</form>';

}


function swingbiz_register_settings() {
    register_setting( 'swingbiz_plugin_options', 'swingbiz_plugin_options', 'swingbiz_plugin_options_validate' );
    add_settings_section( 'teacher_settings', 'Teacher Settings', 'swingbiz_plugin_section_text', 'swingbiz_plugin' );

    add_settings_field( 'swingbiz_plugin_setting_teacher_json', 'Teacher JSON', 'swingbiz_plugin_setting_teacher_json', 'swingbiz_plugin', 'teacher_settings' );
}

add_action( 'admin_init', 'swingbiz_register_settings' );


function swingbiz_plugin_options_validate( $input ) {
    $data = json_decode($input['teacher_json']);
    error_log("Name: " . $data->name);
    error_log("Age: " . $data->age);
    error_log("Car:" . $data->car);

    return $input;
}

function swingbiz_plugin_section_text() {
    echo '<p>Here you can import teacher data in JSON format</p>';
}

function swingbiz_plugin_setting_teacher_json() {
    $options = get_option( 'swingbiz_plugin_options' );

    echo "<textarea id='swingbiz_plugin_setting_teacher_json' name='swingbiz_plugin_options[teacher_json]' rows='4' cols='50'>";
    echo esc_attr($options['teacher_json']);
    echo "</textarea>";


    //echo "<input id='swingbiz_plugin_setting_teacher_json' name='swingbiz_plugin_options[teacher_json]' type='textarea' value='" . esc_attr( $options['teacher_json'] ) . "' />";
}



