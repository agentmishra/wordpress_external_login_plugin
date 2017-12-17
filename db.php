<?php
function exlog_auth_query($username, $password) {
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

    $password_hashed = exlog_hash_password($password);

    $query_string =
        'SELECT *' .
        ' FROM ' . $dbstructure_table .
        ' WHERE ' . $dbstructure_username . '="' . $username . '"' .
        ' AND ' . $dbstructure_password . '="' . $password_hashed .'";';

    $rows = $mydb->get_results($query_string);

    if (sizeof($rows) > 0) {
        $userData = $rows[0];
        if (strtolower($userData->{$dbstructure_role}) == "mentor") {
            $role = 'administrator';
        } else {
            $role = 'subscriber';
        }

        return array(
            "valid" => true,
            "username" => $userData->{$dbstructure_username},
            "password" => $userData->{$dbstructure_password},
            "first_name" => $userData->{$dbstructure_first_name},
            "last_name" => $userData->{$dbstructure_last_name},
            "role" => $role
        );
    } else {
        return array(
            "valid" => false
        );
    }
}