<?php

function exlog_map_role($db_role) {
    if (exlog_get_option("exlog_multiple_roles_toggle") == "on") {
        $delimiter = exlog_get_option("exlog_multiple_roles_delimiter");
        $roles = array_map('trim', explode($delimiter, $db_role));
    } else {
        $roles = $db_role;
    }

    $role_map = exlog_get_role_mappings();

    $wp_roles = array();
    foreach ($roles as $role) {
        foreach ($role_map as $map) {
            if ($map["external_role_value"] == $role) {
                array_push($wp_roles, $map["wordpress_role_value"]);
            }
        }
    }

    // If we've managed to find some roles that can be mapped - return than
    if (count($wp_roles) > 0) {
        return $wp_roles;
    }

    $unspecified_role = exlog_get_option("exlog_unspecified_role");
    if ($unspecified_role != "") {
        return array($unspecified_role);
    } else {
        error_log("External Login Error: User role could not be mapped and no fall back role has been given. The role 'subscriber' has been given");
        return array("subscriber");
    }
}