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
            ),
            array(
                "field_name" => "Database Host",
                "field_description" => "This is the database host. This may well be 'localhost'",
                "field_slug" => "external_login_option_db_host",
            ),
            array(
                "field_name" => "Database Username",
                "field_description" => "The username for the account to access the database.",
                "field_slug" => "external_login_option_db_username",
            ),
            array(
                "field_name" => "Database Password",
                "field_description" => "The password for the account to access the database.",
                "field_slug" => "external_login_option_db_password",
            ),
            array(
                "field_name" => "Database Password Salt",
                "field_description" => "The salt used when hashing the password.",
                "field_slug" => "external_login_option_db_salt",
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
            ),
            array(
                "field_name" => "Username Field Name",
                "field_description" => "This is the name of the field that stores your users' username or other unique ID. It MUST be unique.",
                "field_slug" => "exlog_dbstructure_username",
            ),
            array(
                "field_name" => "Password Field Name",
                "field_description" => "This is the name of the field that stores your users' hashed passwords.",
                "field_slug" => "exlog_dbstructure_password",
            ),
            array(
                "field_name" => "First Name Field Name",
                "field_description" => "This is the name of the field that stores your users' first name.",
                "field_slug" => "exlog_dbstructure_first_name",
            ),
            array(
                "field_name" => "Last Name Field Name",
                "field_description" => "This is the name of the field that stores your users' last name.",
                "field_slug" => "exlog_dbstructure_last_name",
            ),
            array(
                "field_name" => "Role Field Name",
                "field_description" => "This is the name of the field that stores your users' role. This could be admin, subscriber, etc.",
                "field_slug" => "exlog_dbstructure_role",
            ),
        )
    )
);