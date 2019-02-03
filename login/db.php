<?php

function exlog_get_external_db_instance_and_fields($dbType = false) {
    if (!$dbType) {
        $dbType = exlog_get_option('external_login_option_db_type');
    }

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

        $db_instance = pg_connect($postgresConnectionString) or error_log("EXLOG: Cannot connect to the external database.");
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
        "db_type" => $dbType,
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

    $exclude_query_string_component = "";
    if (exlog_get_option('external_login_option_enable_exclude_users') == "on") {
        $exclude_query_string_component = exlog_build_exclude_query_string_component($db_data);
    }

    if ($dbType == "postgresql") {
        $query_string =
            'SELECT *' .
            ' FROM "' . esc_sql($db_data["dbstructure_table"]) . '"' .
            ' WHERE "' . esc_sql($db_data["dbstructure_username"]) . '" ILIKE \'' . esc_sql($username) . '\'' .
         $exclude_query_string_component;

        $rows = pg_query($query_string) or error_log("EXLOG: External DB query failed.");

        $userData = pg_fetch_array($rows, null, PGSQL_ASSOC); //Gets the first row

        pg_close($db_data["db_instance"]);

    } else {
        $query_string =
            'SELECT *' .
            ' FROM ' . esc_sql($db_data["dbstructure_table"]) .
            ' WHERE ' . esc_sql($db_data["dbstructure_username"]) . '="' . esc_sql($username) . '"' .
            $exclude_query_string_component;

        $rows = $db_data["db_instance"]->get_results($query_string, ARRAY_A);

        if (sizeof($rows) > 0) {
            $userData = $rows[0];
        }
    }

    if ($userData) {
        $user_specific_salt = false;

        if (exlog_get_option('external_login_option_db_salting_method') == 'all') {
            $user_specific_salt =  $userData[$db_data["dbstructure_salt"]];
        }

        $valid_credentials = exlog_validate_password($password, $userData[$db_data["dbstructure_password"]], $user_specific_salt);

        if ($valid_credentials) {
            $wp_user_data = exlog_build_wp_user_data($db_data, $userData);
            $wp_user_data["exlog_authenticated"] = true;
            return $wp_user_data;
        } else {
            $user_data["exlog_authenticated"] = false;
            return $userData;
        }
    } else {
        return false;
    }
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
            pg_close($db_data["db_instance"]);
            return $users;
        }

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

function exlog_build_exclude_query_string_component($db_data) {
    $dbType = exlog_get_option('external_login_option_db_type');
    $exclude_users_data = exlog_get_option('exlog_exclude_users_field_name_repeater');

    $exclude_query_string_section = "";
    if (gettype($exclude_users_data) == 'array') {
        foreach ($exclude_users_data as $field) {
            $field_name = $field['exlog_exclude_users_field_name'];
            if (!exlog_check_if_field_exists($db_data, $field_name)) {
                continue;
            }

            $field_values = $field['exlog_exclude_users_field_value_repeater'];
            foreach ($field_values as $value_object) {
                $value = $value_object['exlog_exclude_users_field_value'];
                if ($dbType == "postgresql") {
                    $string_part = ' AND "' . esc_sql($field_name) . '"::text NOT ILIKE \'' . esc_sql($value) . '\'';
                } else {
                    $string_part = ' AND NOT ' . esc_sql($field_name) . '="' . esc_sql($value) . '"';
                }
                $exclude_query_string_section .= $string_part;
            }
        }
    }
    return $exclude_query_string_section;
}

function exlog_check_if_field_exists($db_data, $field) {
    $dbType = exlog_get_option('external_login_option_db_type');
    if ($dbType == "mysql") {
        $query_string = "SHOW COLUMNS FROM `" . esc_sql($db_data["dbstructure_table"]) . "` LIKE '" . $field . "';";
        $result = $db_data["db_instance"]->get_results($query_string, ARRAY_A);
        return !empty($result);
    } else {
        $query_string = "SELECT column_name FROM information_schema.columns WHERE table_name='" . $db_data["dbstructure_table"] ."' and column_name='" . $field . "';";
        $query_results = pg_query($query_string) or error_log("EXLOG: External DB query failed when checking if Field Exists");
        $result = pg_fetch_array($query_results, null, PGSQL_ASSOC);
        return is_array($result);
    }
}

function exlog_does_value_exists_in_field($field, $value, $db_data = false, $force_case_insensitive = true) {
    if (!$db_data) {
        $db_data = exlog_get_external_db_instance_and_fields();
    }

    if ($db_data["db_type"] == "mysql") {
        $query_string =
            'SELECT *' .
            ' FROM ' . esc_sql($db_data["dbstructure_table"]);

            if ($force_case_insensitive) {
                $query_string .= ' WHERE LOWER(' . esc_sql($field) . ')=LOWER("' . esc_sql($value) . '");';
            } else {
                $query_string .= ' WHERE ' . esc_sql($field) . '="' . esc_sql($value) . '";';
            }

        $rows = $db_data["db_instance"]->get_results($query_string, ARRAY_A);

        return sizeof($rows) > 0;

    } else {
        $query_comparison_operator = ($force_case_insensitive ? "ILIKE" : "LIKE");

        $query_string =
            'SELECT *' .
            ' FROM "' . esc_sql($db_data["dbstructure_table"]) . '"' .
            ' WHERE "' . esc_sql($field) . '" ' . $query_comparison_operator . ' \'' . esc_sql($value) . '\';';

        $rows = pg_query($query_string) or error_log("EXLOG: External DB query failed. (DVE)");

        $userData = pg_fetch_array($rows, null, PGSQL_ASSOC); //Gets the first row

        pg_close($db_data["db_instance"]);
        return $userData == true;
    }
}

function exlog_add_new_user_to_external_db($insert_data, $db_data = false) {
    if (!$db_data) {
        $db_data = exlog_get_external_db_instance_and_fields();
    }
    //    Check if all fields exist
    if ($db_data["db_type"] == "mysql") {
        $rows = $db_data["db_instance"]->insert(exlog_get_option('exlog_dbstructure_table'), $insert_data);

        if($db_data["db_instance"]->last_error !== '') :
            $db_data["db_instance"]->print_error();
        endif;

        return ($rows);

    } else {
        $fieldStrings = [];
        $valueStrings = [];
        foreach ($insert_data as $field => $value) {
            array_push($fieldStrings, '"' . esc_sql($field) . '"');
            array_push($valueStrings, '\'' . esc_sql($value) . '\'');
        }

        $query_string = "INSERT INTO \"" .
            exlog_get_option('exlog_dbstructure_table') .
            "\"(" . implode(", ", $fieldStrings) .
            ") VALUES (" .
            implode(", ", $valueStrings) .
            ");";

        $result = pg_query($query_string) or error_log("EXLOG: External DB query failed when adding user");
        $affected_rows = pg_affected_rows($result);
        pg_close($db_data["db_instance"]);

        return $affected_rows > 0;
    }
}

function exlog_update_password_in_external_db($username, $hashed_password, $db_data = false) {
    if (!$db_data) {
        $db_data = exlog_get_external_db_instance_and_fields();
    }

    if ($db_data["db_type"] == "mysql") {
        $rows = $db_data["db_instance"]->update(
            exlog_get_option('exlog_dbstructure_table'),
            array(
                exlog_get_option('exlog_dbstructure_password') => $hashed_password
            ),
            array( exlog_get_option('exlog_dbstructure_username') => $username )
        );

        if($db_data["db_instance"]->last_error !== '') {
            $db_data["db_instance"]->print_error();
            return false;
        }

        return ($rows);

    } else {
        $query_string = "UPDATE \"" .
            exlog_get_option('exlog_dbstructure_table') .
            "\" SET \"" . exlog_get_option('exlog_dbstructure_password') . "\" = '" . $hashed_password . "'" .
            " WHERE \"" . exlog_get_option('exlog_dbstructure_username') . "\" = '" . $username . "';";

        $result = pg_query($query_string) or error_log("EXLOG: External DB query failed when updating password.");
        $affected_rows = pg_affected_rows($result);
        pg_close($db_data["db_instance"]);

        return $affected_rows > 0;
    }
}