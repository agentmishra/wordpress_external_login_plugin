<?php
function exlog_auth_query($username, $password) {

    function exlog_validate_password($password, $hash) {
        $algorithm = get_option("external_login_option_hash_algorithm");
        if ($algorithm == "bcrypt") {
            return password_verify($password, $hash);
        } else {
            return exlog_hash_password($password) == $hash;
        }
    }

    function exlog_get_role($db_role) {
        if (strtolower($db_role) == "mentor") {
            return 'administrator';
        } else {
            return 'subscriber';
        }
    }

    $dbstructure_table = get_option('exlog_dbstructure_table');
    $dbstructure_username = get_option('exlog_dbstructure_username');
    $dbstructure_password = get_option('exlog_dbstructure_password');
    $dbstructure_first_name = get_option('exlog_dbstructure_first_name');
    $dbstructure_last_name = get_option('exlog_dbstructure_last_name');
    $dbstructure_role = get_option('exlog_dbstructure_role');

    $mydb = new wpdb(
        get_option("external_login_option_db_username"),
        get_option("external_login_option_db_password"),
        get_option("external_login_option_db_name"),
        get_option("external_login_option_db_host")
    );

    $query_string =
        'SELECT *' .
        ' FROM ' . $dbstructure_table .
        ' WHERE ' . $dbstructure_username . '="' . $username . '"';

    $rows = $mydb->get_results($query_string);

    if (sizeof($rows) > 0) {
        $userData = $rows[0];
        if (exlog_validate_password($password, $userData->{$dbstructure_password})) {
            $role = exlog_get_role($userData->{$dbstructure_role});

            return array(
                "valid" => true,
                "username" => $userData->{$dbstructure_username},
                "password" => $userData->{$dbstructure_password},
                "first_name" => $userData->{$dbstructure_first_name},
                "last_name" => $userData->{$dbstructure_last_name},
                "role" => $role
            );
        }
    }

//    If not yet returned a valid user they must be invalid.
    return array(
        "valid" => false
    );
}