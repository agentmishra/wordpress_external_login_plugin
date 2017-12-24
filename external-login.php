<?php
/*
Plugin Name: External Login
Plugin URI: http://tom.benyon.io
Description: A plugin to allow login and syncing from a secondary database
Author: Tom Benyon
Version: 0.1.0
Author URI: http://tom.benyon.io
Text Domain: external-login
*/

$EXLOG_PATH_PLUGIN_BASE = __DIR__;
$EXLOG_PATH_PLUGIN_VIEWS = $EXLOG_PATH_PLUGIN_BASE . '/views';
$EXLOG_PLUGIN_DATA = get_file_data(__FILE__, [
    'name' => 'Plugin Name',
    'slug' => 'Text Domain'
], 'plugin');

include 'hashPassword.php';
include 'db.php';
include 'options_fields.php';
include 'options_external_login.php';
include 'authenticate.php';
