<?php

class Exlog_user_registration {
    public static function setup_user_registration() {
        if (exlog_get_option("exlog_enable_user_registration") == "on") {
            error_log("REGISTRATION ACTIVATED");
        }
    }

}