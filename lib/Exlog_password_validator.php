<?php

class Exlog_password_validator {

    public function get_salting_method() {
        return exlog_get_option("external_login_option_db_salting_method");
    }

    public function get_algorithm_type() {
        return exlog_get_option("external_login_option_hash_algorithm");
    }
}