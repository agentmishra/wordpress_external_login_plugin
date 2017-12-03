<?php

$mydb = new wpdb(
    get_option("external_login_option_db_username"),
    get_option("external_login_option_db_password"),
    get_option("external_login_option_db_name"),
    get_option("external_login_option_db_host")
);
$rows = $mydb->get_results('select ' . $dbstructure_username . ' from ' . $dbstructure_table);

if (!is_admin()) {
    echo "<ul>";
    foreach ($rows as $obj) :
        echo "<li>".$obj->{$dbstructure_username}."</li>";
    endforeach;
    echo "</ul>";
}