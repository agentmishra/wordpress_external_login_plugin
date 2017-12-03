<?php
/*
Plugin Name: External Login
Plugin URI: http://tom.benyon.io
Description: A plugin to allow login and syncing from a secondary database
Author: Tom Benyon
Version: 0.1.0
Author URI: http://tom.benyon.io
*/

$db_name = "dojo2016";
$db_usernme = "root";
$db_password = "root";
$db_host = "localhost";

$dbstructure_table = "User";
$dbstructure_username = "NickName";
$dbstructure_password = "Password";
$dbstructure_first_name = "FirstName";
$dbstructure_last_name = "LastName";
$dbstructure_dob = "DOB";

include 'db.php';