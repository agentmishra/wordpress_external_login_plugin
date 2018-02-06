<?php

//If a constant is defined for an option, make that take president
function exlog_get_option($option_name) {
    if (defined(strtoupper($option_name))) {
        return constant(strtoupper($option_name));
    } else {
        return get_option($option_name);
    }
}

function exlog_is_wpconfig_option_set($option_name) {
    return defined(strtoupper($option_name));
}
