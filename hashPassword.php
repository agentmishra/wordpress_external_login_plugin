<?php
    function exlog_hash_password($password) {
        return hash('sha512', $password . get_option("external_login_option_db_salt"));
    }