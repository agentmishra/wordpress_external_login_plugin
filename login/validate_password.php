<?php
    function exlog_hash_password($password) {
        $algorithm = get_option("external_login_option_hash_algorithm");
        $salt = get_option("external_login_option_db_salt");
        $salt_location = get_option("external_login_option_db_salt_location");

        if ($salt_location == "before") {
            return hash($algorithm, $salt . $password);
        } elseif ($salt_location == "after") {
            return hash($algorithm, $password . $salt);
        } else {
            return hash($algorithm, $password);
        }
    }

    function exlog_validate_password($password, $hash) {
        $algorithm = get_option("external_login_option_hash_algorithm");
        if ($algorithm == "bcrypt") {
            return password_verify($password, $hash);
        } else {
            return exlog_hash_password($password) == $hash;
        }
    }
