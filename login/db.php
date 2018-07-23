<?php

function exlog_get_external_db_instance_and_fields($dbType) {
    $host = exlog_get_option("external_login_option_db_host");
    $port = exlog_get_option("external_login_option_db_port");
    $user = exlog_get_option("external_login_option_db_username");
    $password = exlog_get_option("external_login_option_db_password");
    $dbname = exlog_get_option("external_login_option_db_name");

    $db_instance = null;
    $mySqlHost = null;

    if ($dbType == "postgresql") {
        $postgresConnectionString = "";
        if ($host) {
            $postgresConnectionString .= " host=" . $host;
        }

        if ($port) {
            $postgresConnectionString .= " port=" . $port;
        }

        if ($user) {
            $postgresConnectionString .= " user=" . $user;
        }

        if ($password) {
            $postgresConnectionString .= " password=" . $password;
        }

        if ($dbname) {
            $postgresConnectionString .= " dbname=" . $dbname;
        }

        $db_instance = pg_connect($postgresConnectionString) or die('Cannot connect to external database.'); //IMPROVE THIS HANDLING!!!!!!!!!!
    } else {
        $mySqlHost = $host;

        $hostIncludesPort = strpos($host, ':') !== false;

        if ($port && !$hostIncludesPort) { //If port is included in $host, don't add the $port variable as well
            $mySqlHost .= ":" . $port;
        }

        $db_instance = new wpdb(
            $user,
            $password,
            $dbname,
            $mySqlHost
        );
    }

    $data = array(
        "db_instance" => $db_instance,
        "dbstructure_table" => exlog_get_option('exlog_dbstructure_table'),
        "dbstructure_username" => exlog_get_option('exlog_dbstructure_username'),
        "dbstructure_password" => exlog_get_option('exlog_dbstructure_password'),
        "dbstructure_first_name" => exlog_get_option('exlog_dbstructure_first_name'),
        "dbstructure_last_name" => exlog_get_option('exlog_dbstructure_last_name'),
        "dbstructure_role" => exlog_get_option('exlog_dbstructure_role'),
        "dbstructure_email" => exlog_get_option('exlog_dbstructure_email'),
    );

    if (exlog_get_option('external_login_option_db_salting_method') == 'all') {
        $data['dbstructure_salt'] = exlog_get_option('exlog_dbstructure_salt');
    }

    return $data;
};

function exlog_build_wp_user_data($db_data, $userData) {
    return array(
        "username" => $userData[$db_data["dbstructure_username"]],
        "password" => $userData[$db_data["dbstructure_password"]],
        "first_name" => $userData[$db_data["dbstructure_first_name"]],
        "last_name" => $userData[$db_data["dbstructure_last_name"]],
        "role" => $userData[$db_data["dbstructure_role"]],
        "email" => $userData[$db_data["dbstructure_email"]],
    );
}

function exlog_auth_query($username, $password) {
    $dbType = exlog_get_option('external_login_option_db_type');

    $db_data = exlog_get_external_db_instance_and_fields($dbType);

    $userData = null;

    if ($dbType == "postgresql") {
        $query_string =
            'SELECT *' .
            ' FROM "' . esc_sql($db_data["dbstructure_table"]) . '"' .
            ' WHERE "' . esc_sql($db_data["dbstructure_username"]) . '" ILIKE \'' . esc_sql($username) . '\'';

        $rows = pg_query($query_string) or die('Query failed: ' . pg_last_error());

        $userData = pg_fetch_array($rows, null, PGSQL_ASSOC); //Gets the first row

        pg_close($db_data["db_instance"]);

    } else {
        $query_string =
            'SELECT *' .
            ' FROM ' . esc_sql($db_data["dbstructure_table"]) .
            ' WHERE ' . esc_sql($db_data["dbstructure_username"]) . '="' . esc_sql($username) . '"';

        $rows = $db_data["db_instance"]->get_results($query_string, ARRAY_A);

        if (sizeof($rows) > 0) {
            $userData = $rows[0];
        }
    }


    $user_specific_salt = false;

    if (exlog_get_option('external_login_option_db_salting_method') == 'all') {
        $user_specific_salt =  $userData[$db_data["dbstructure_salt"]];
    }

    $valid_credentials = exlog_validate_password($password, $userData[$db_data["dbstructure_password"]], $user_specific_salt);

    if ($valid_credentials) {
        $wp_user_data = exlog_build_wp_user_data($db_data, $userData);
        $wp_user_data["valid"] = true;
        return $wp_user_data;
    }

//    If not yet returned a valid user they must be invalid.
    return array(
        "valid" => false
    );
}

function exlog_test_query($limit = false) {
    $dbType = exlog_get_option('external_login_option_db_type');

    $db_data = exlog_get_external_db_instance_and_fields($dbType);

    if ($dbType == "postgresql") {
        $query_string =
            'SELECT *' .
            ' FROM "' . esc_sql($db_data["dbstructure_table"]) . '"';

        if ($limit && is_int($limit)) {
            $query_string .= ' LIMIT ' . $limit;
        }

        $rows = pg_query($query_string) or die('Query failed: ' . pg_last_error());

        $users = array();
        if (sizeof($rows) > 0) {
            while ($x = pg_fetch_array($rows, null, PGSQL_ASSOC)) {
                array_push($users, $x); //Gets the first row
            };
            return $users;
        }

        pg_close($db_data["db_instance"]);

    } else {
        $query_string =
            'SELECT *' .
            ' FROM ' . esc_sql($db_data["dbstructure_table"]) . '';

        if ($limit && is_int($limit)) {
            $query_string .= ' LIMIT ' . $limit;
        }

        $rows = $db_data["db_instance"]->get_results($query_string, ARRAY_A);

        $users = array();
        if (sizeof($rows) > 0) {
            foreach ($rows as $user_data) {
                array_push($users, exlog_build_wp_user_data($db_data, $user_data));
            };
            return $users;
        }
    }


//If got this far, query failed
    error_log("External Login - No rows returned from test query.");
    return false;
}
