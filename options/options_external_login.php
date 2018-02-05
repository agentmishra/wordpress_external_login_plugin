<?php
/* Add Custom Admin Menu */
add_action( 'admin_menu', 'exlog_create_options_menu' );
add_action( 'admin_init', 'exlog_register_options_menu_settings');

function exlog_register_options_menu_settings() {
    foreach (EXLOG_OPTION_FIELDS as $section) {
        foreach ($section['section_fields'] as $form_field) {
            register_setting(EXLOG_PLUGIN_DATA['slug'] . '-option-group', $form_field["field_slug"], function( $input ) use ( $form_field ) {
                return exlog_validate( $input, $form_field );
            });
        }
    }
};

function exlog_create_options_menu() {
    add_options_page( EXLOG_PLUGIN_DATA['name'] . ' Options', EXLOG_PLUGIN_DATA['name'], 'manage_options', EXLOG_PLUGIN_DATA['slug'], 'exlog_generate_options_view' );
}

function exlog_generate_options_view() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    }

    include EXLOG_PATH_PLUGIN_VIEWS . '/options_page.php';
}

add_action( 'admin_enqueue_scripts', 'exlog_enqueue_for_options' );

function exlog_enqueue_for_options() {
    wp_enqueue_style( 'exlog-styles', plugin_dir_url(EXLOG_PATH_PLUGIN_BASE) . EXLOG_PLUGIN_DATA['slug'] . '/styles/style.css' );
    wp_enqueue_script( 'exlog-validation-tools', plugin_dir_url(EXLOG_PATH_PLUGIN_BASE) . EXLOG_PLUGIN_DATA['slug'] . '/js/tools.js' );
    wp_enqueue_script( 'exlog-scripts', plugin_dir_url(EXLOG_PATH_PLUGIN_BASE) . EXLOG_PLUGIN_DATA['slug'] . '/js/external_login.js' );
    wp_enqueue_script( 'exlog-option-conditionals', plugin_dir_url(EXLOG_PATH_PLUGIN_BASE) . EXLOG_PLUGIN_DATA['slug'] . '/js/options_condtionals.js' );
    wp_enqueue_script( 'exlog-test', plugin_dir_url(EXLOG_PATH_PLUGIN_BASE) . EXLOG_PLUGIN_DATA['slug'] . '/js/exlog_test.js' );
}
