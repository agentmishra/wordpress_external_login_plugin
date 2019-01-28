<?php

class Exlog_user_registration {
    public static function setup_user_registration() {
        if (exlog_get_option("exlog_disble_user_registration") == "on") {
            update_option('users_can_register', false);
        } else {
            $self = new self();
            update_option('users_can_register', true);

            //Fired when user tries to registers a user. See "Source" here: https://developer.wordpress.org/reference/functions/register_new_user/
            add_filter('register_post', array($self, "before_user_is_registered"), 10, 3 );
        }
    }

    public function before_user_is_registered($sanitized_user_login, $user_email, $errors) {
        // If no errors from user existing in WP DB - check External DB
        if (count($errors->get_error_codes()) == 0) {
            //    Need to check if username exists
            if (exlog_does_value_exists_in_field(exlog_get_option('exlog_dbstructure_username'), $sanitized_user_login)) {
                $errors->add('username_exists', "The username is already registered to another user.");

            } else if (exlog_does_value_exists_in_field(exlog_get_option('exlog_dbstructure_email'), $user_email)) {
                $errors->add('email_exists', "The e-mail is already registered to another user.");
            }
        }

        return $errors;
    }
}