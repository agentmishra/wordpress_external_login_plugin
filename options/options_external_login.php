<?php
/* Add Custom Admin Menu */
add_action( 'admin_menu', 'exlog_create_options_menu' );
add_action( 'admin_init', 'exlog_register_options_menu_settings');

function exlog_register_options_menu_settings() {
    global $EXLOG_PLUGIN_DATA;
    global $EXLOG_OPTION_FIELDS;

    foreach ($EXLOG_OPTION_FIELDS as $section) {
        foreach ($section['section_fields'] as $form_field) {
            register_setting($EXLOG_PLUGIN_DATA['slug'] . '-option-group', $form_field["field_slug"]);
        }
    }
};

function exlog_create_options_menu() {
    global $EXLOG_PLUGIN_DATA;
    add_options_page( $EXLOG_PLUGIN_DATA['name'] . ' Options', $EXLOG_PLUGIN_DATA['name'], 'manage_options', $EXLOG_PLUGIN_DATA['slug'] . '-identifier', 'exlog_generate_options_view' );
}

function exlog_generate_options_view() {
    global $EXLOG_PATH_PLUGIN_VIEWS;
    global $EXLOG_PLUGIN_DATA;
    global $EXLOG_OPTION_FIELDS;

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    }

    include $EXLOG_PATH_PLUGIN_VIEWS . '/options_page.php';
}

add_action( 'admin_enqueue_scripts', 'exlog_enqueue_for_options' );

function exlog_enqueue_for_options() {
    global $EXLOG_PATH_PLUGIN_BASE;
    global $EXLOG_PLUGIN_DATA;
    wp_enqueue_style( 'exlog-styles', plugin_dir_url($EXLOG_PATH_PLUGIN_BASE) . $EXLOG_PLUGIN_DATA['slug'] . '/scss/style.css' );
    wp_enqueue_script( 'exlog-validation-tools', plugin_dir_url($EXLOG_PATH_PLUGIN_BASE) . $EXLOG_PLUGIN_DATA['slug'] . '/js/tools.js' );
    wp_enqueue_script( 'exlog-scripts', plugin_dir_url($EXLOG_PATH_PLUGIN_BASE) . $EXLOG_PLUGIN_DATA['slug'] . '/js/external_login.js' );
}
