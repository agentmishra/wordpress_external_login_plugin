<?php
function exlog_get_wp_role_types() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    return array_reverse($wp_roles->get_names());
}

function exlog_get_role_mappings() {
    $raw_data = get_option('exlog_roles_custom_fields');
    return json_decode(urldecode($raw_data), true);
}
