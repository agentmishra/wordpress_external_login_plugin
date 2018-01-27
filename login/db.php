<?php

function exlog_get_external_db_instance_and_fields() {
    $data = array(
        "db_instance" => new wpdb(
            get_option("external_login_option_db_username"),
            get_option("external_login_option_db_password"),
            get_option("external_login_option_db_name"),
            get_option("external_login_option_db_host")
        ),
        "dbstructure_table" => get_option('exlog_dbstructure_table'),
        "dbstructure_username" => get_option('exlog_dbstructure_username'),
        "dbstructure_password" => get_option('exlog_dbstructure_password'),
        "dbstructure_first_name" => get_option('exlog_dbstructure_first_name'),
        "dbstructure_last_name" => get_option('exlog_dbstructure_last_name'),
        "dbstructure_role" => get_option('exlog_dbstructure_role'),
    );

    if (get_option('external_login_option_db_salting_method') == 'all') {
        $data['dbstructure_salt'] = get_option('exlog_dbstructure_salt');
    }

    return $data;
};

function exlog_build_wp_user_data($db_data, $userData) {
    return array(
        "username" => $userData->{$db_data["dbstructure_username"]},
        "password" => $userData->{$db_data["dbstructure_password"]},
        "first_name" => $userData->{$db_data["dbstructure_first_name"]},
        "last_name" => $userData->{$db_data["dbstructure_last_name"]},
        "role" => $userData->{$db_data["dbstructure_role"]}
    );
}

function exlog_auth_query($username, $password) {
    $db_data = exlog_get_external_db_instance_and_fields();

    $query_string =
        'SELECT *' .
        ' FROM ' . $db_data["dbstructure_table"] .
        ' WHERE ' . $db_data["dbstructure_username"] . '="' . $username . '"';

    $rows = $db_data["db_instance"]->get_results($query_string);

    if (sizeof($rows) > 0) {
        $userData = $rows[0];

        $user_specific_salt = false;

        if (get_option('external_login_option_db_salting_method') == 'all') {
            $user_specific_salt =  $userData->{$db_data["dbstructure_salt"]};
        }

        $valid_credentials = exlog_validate_password($password, $userData->{$db_data["dbstructure_password"]}, $user_specific_salt);

        if ($valid_credentials) {
            $wp_user_data = exlog_build_wp_user_data($db_data, $userData);
            $wp_user_data["valid"] = true;
            return $wp_user_data;
        }
    }

//    If not yet returned a valid user they must be invalid.
    return array(
        "valid" => false
    );
}

function exlog_test_query($limit = false) {
    $db_data = exlog_get_external_db_instance_and_fields();

    $query_string =
        'SELECT *' .
        ' FROM ' . $db_data["dbstructure_table"] ;

    if ($limit && is_int($limit)) {
        $query_string .= ' LIMIT ' . $limit;
    }

    $rows = $db_data["db_instance"]->get_results($query_string);

    $users = array();
    if (sizeof($rows) > 0) {
        foreach ($rows as $user_data) {
            array_push($users, exlog_build_wp_user_data($db_data, $user_data));
        };
        return $users;
    }

//If got this far, query failed
    error_log("External Login - No rows returned from test query.");
    return false;
}
