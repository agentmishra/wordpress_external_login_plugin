<?php
    function exlog_hash_password($password, $no_salt = false) {
        $algorithm = get_option("external_login_option_hash_algorithm");
        $salt = get_option("external_login_option_db_salt");
        $salt_location = get_option("external_login_option_db_salt_location");

        if ($no_salt) {
            return hash($algorithm, $password);
        } else if ($salt_location == "before") {
            return hash($algorithm, $salt . $password);
        } elseif ($salt_location == "after") {
            return hash($algorithm, $password . $salt);
        } else {
            return hash($algorithm, $password);
        }
    }

    function exlog_validate_password($password, $hash) {
        $salt_method = get_option("external_login_option_db_salting_method");
        $algorithm = get_option("external_login_option_hash_algorithm");

        if ($algorithm == "bcrypt") {
            return password_verify($password, $hash);
        } else {
            if ($salt_method == 'none') {
                return exlog_hash_password($password, true) == $hash;
            } else {
                return exlog_hash_password($password) == $hash;
            }
        }
    }
