<?php
    function exlog_hash_password($password) {
        if (get_option("external_login_option_db_salt_location") == "before") {
            return hash('sha512', get_option("external_login_option_db_salt") . $password);
        } elseif (get_option("external_login_option_db_salt_location") == "after") {
            return hash('sha512', $password . get_option("external_login_option_db_salt"));
        } else {
            return hash('sha512', $password);
        }
    }