<?php

function exlog_map_role($db_role) {
    $role_map = exlog_get_role_mappings();

    foreach ($role_map as $map) {
        if ($map["external_role_value"] == $db_role) {
            return $map["wordpress_role_value"];
        }
    }

    $unspecified_role = exlog_get_option("exlog_unspecified_role");
    if ($unspecified_role != "") {
        return $unspecified_role;
    } else {
        error_log("External Login Error: User role could not be mapped and no fall back role has been given. The role 'subscriber' has been given");
        return "subscriber";
    }
}