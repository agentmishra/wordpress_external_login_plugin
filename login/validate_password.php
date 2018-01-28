<?php
    function exlog_hash_password($password, $no_salt = false, $user_specific_salt = false) {
        $algorithm = get_option("external_login_option_hash_algorithm");
        $salt_location = get_option("external_login_option_db_salt_location");
        if ($user_specific_salt) {
            $salt = $user_specific_salt;
        } else {
            $salt = get_option("external_login_option_db_salt");
        }

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

    function exlog_validate_password($password, $hash, $user_specific_salt) {
        $salt_method = get_option("external_login_option_db_salting_method");
        $algorithm = get_option("external_login_option_hash_algorithm");

        $hash = exlog_should_lowercase_hex_hash($algorithm, $hash);

        if ($algorithm == "bcrypt") {
            return password_verify($password, $hash);
        } else {
            if ($salt_method == 'none') {
                return exlog_hash_password($password, true) == $hash;
            } else if ($salt_method == 'all') {
                return exlog_hash_password($password, false, $user_specific_salt) == $hash;
            } else {
                return exlog_hash_password($password) == $hash;
            }
        }
    }

//    Because a hash represented in hexidecimal could be represented in lower case or upper,
//    make it compatible with PHPs lowercase system
    function exlog_should_lowercase_hex_hash($algorithm, $hash) {
        if ($algorithm === "bcrypt") {
            return $hash;
        } else {
            return strtolower($hash);
        }

    }
