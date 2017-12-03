<?php

$mydb = new wpdb($db_usernme, $db_password, $db_name, $db_host);
$rows = $mydb->get_results('select ' . $dbstructure_username . ' from ' . $dbstructure_table);

if (!is_admin()) {
    echo "<ul>";
    foreach ($rows as $obj) :
        echo "<li>".$obj->{$dbstructure_username}."</li>";
    endforeach;
    echo "</ul>";
}