<?php

$EXLOG_OPTION_FIELDS = array(
    array(
        "section_name" => "Database Connection",
        "section_slug" => "database_connection",
        "section_description" => "These settings are for connecting to the database.",
        "section_fields" => array(
            array(
                "field_name" => "Database Name",
                "field_description" => "This is the name of the database to connect to.",
                "field_slug" => "external_login_option_db_name",
                "type" => "text",
            ),
            array(
                "field_name" => "Database Host",
                "field_description" => "This is the database host. This may well be 'localhost'",
                "field_slug" => "external_login_option_db_host",
                "type" => "text",
            ),
            array(
                "field_name" => "Database Username",
                "field_description" => "The username for the account to access the database.",
                "field_slug" => "external_login_option_db_username",
                "type" => "text",
            ),
            array(
                "field_name" => "Database Password",
                "field_description" => "The password for the account to access the database.",
                "field_slug" => "external_login_option_db_password",
                "type" => "text",
            ),
            array(
                "field_name" => "Salt Location",
                "field_description" => "Whether the salt is concatenated before or after the password.",
                "field_slug" => "external_login_option_db_salt_location",
                "type" => "select",
                "select_options" => array(
                    "none" => "No Salt",
                    "before" => "Salt Before",
                    "after" => "Salt After"
                )
            ),
            array(
                "field_name" => "Database Password Salt",
                "field_description" => "The salt used when hashing the password. If no salt is specified above this will have no effect.",
                "field_slug" => "external_login_option_db_salt",
                "type" => "text",
            ),
        ),
    ),
    array(
        "section_name" => "Database Table Mapping",
        "section_slug" => "database_table_mapping",
        "section_description" => "These settings are for mapping the data in your users table with that that will be stored in this WordPress database.",
        "section_fields" => array(
            array(
                "field_name" => "Table Name",
                "field_description" => "The name of the table that stores your users.",
                "field_slug" => "exlog_dbstructure_table",
                "type" => "text",
            ),
            array(
                "field_name" => "Username Field Name",
                "field_description" => "This is the name of the field that stores your users' username or other unique ID. It MUST be unique.",
                "field_slug" => "exlog_dbstructure_username",
                "type" => "text",
            ),
            array(
                "field_name" => "Password Field Name",
                "field_description" => "This is the name of the field that stores your users' hashed passwords.",
                "field_slug" => "exlog_dbstructure_password",
                "type" => "text",
            ),
            array(
                "field_name" => "First Name Field Name",
                "field_description" => "This is the name of the field that stores your users' first name.",
                "field_slug" => "exlog_dbstructure_first_name",
                "type" => "text",
            ),
            array(
                "field_name" => "Last Name Field Name",
                "field_description" => "This is the name of the field that stores your users' last name.",
                "field_slug" => "exlog_dbstructure_last_name",
                "type" => "text",
            ),
            array(
                "field_name" => "Role Field Name",
                "field_description" => "This is the name of the field that stores your users' role. This could be admin, subscriber, etc.",
                "field_slug" => "exlog_dbstructure_role",
                "type" => "text",
            ),
        )
    ),
    array(
        "section_name" => "Feature Settings",
        "section_slug" => "feature_settings",
        "section_description" => "These settings are for functionality of the plugin.",
        "section_fields" => array(
            array(
                "field_name" => "Disable Local Login",
                "field_description" => "Tick this box if you want to disable the login attempt with the Wordpress Database if the external login fails.",
                "field_slug" => "external_login_option_disable_local_login",
                "type" => "checkbox",
            ),
        ),
    ),
);