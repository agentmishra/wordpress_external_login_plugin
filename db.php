<?php
function ex_login_db_query($username, $password) {
    global $dbstructure_username;
    global $dbstructure_password;
    global $dbstructure_first_name;
    global $dbstructure_last_name;
    global $dbstructure_table;

    $mydb = new wpdb(
        get_option("external_login_option_db_username"),
        get_option("external_login_option_db_password"),
        get_option("external_login_option_db_name"),
        get_option("external_login_option_db_host")
    );

    $password_hashed = hash('sha512', $password . get_option("external_login_option_db_salt"));

    $query_string =
        'SELECT *' .
        ' FROM ' . $dbstructure_table .
        ' WHERE ' . $dbstructure_username . '="' . $username . '"' .
        ' AND ' . $dbstructure_password . '="' . $password_hashed .'";';

    $rows = $mydb->get_results($query_string);

    if (sizeof($rows) > 0) {
        $userData = $rows[0];
        return array(
            "valid" => true,
            "username" => $userData->{$dbstructure_username},
            "password" => $userData->{$dbstructure_password},
            "first_name" => $userData->{$dbstructure_first_name},
            "last_name" => $userData->{$dbstructure_last_name},
        );
    } else {
        return array(
            "valid" => false
        );
    };
}