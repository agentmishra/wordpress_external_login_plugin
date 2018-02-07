<?php

//If a constant is defined for an option, make that take president
function exlog_get_option($option_name) {
    $constant_option_name = strtoupper($option_name);

    if (defined($constant_option_name)) {
        return constant($constant_option_name);
    } else {
        return get_option($option_name);
    }
}

function exlog_is_wpconfig_option_set($option_name) {
    return defined(strtoupper($option_name));
}
