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
$EXLOG_PATH_PLUGIN_LOGIN = $EXLOG_PATH_PLUGIN_BASE . '/login';
$EXLOG_PATH_PLUGIN_OPTIONS = $EXLOG_PATH_PLUGIN_BASE . '/options';
$EXLOG_PATH_PLUGIN_TOOLS = $EXLOG_PATH_PLUGIN_BASE . '/tools';
$EXLOG_PLUGIN_DATA = get_file_data(__FILE__, [
    'name' => 'Plugin Name',
    'slug' => 'Text Domain'
], 'plugin');

include $EXLOG_PATH_PLUGIN_TOOLS . '/get_roles.php';
include $EXLOG_PATH_PLUGIN_OPTIONS . '/options_fields.php';
include $EXLOG_PATH_PLUGIN_OPTIONS . '/options_external_login.php';
include $EXLOG_PATH_PLUGIN_LOGIN . '/hashPassword.php';
include $EXLOG_PATH_PLUGIN_LOGIN . '/db.php';
include $EXLOG_PATH_PLUGIN_LOGIN . '/authenticate.php';
