<?php

class Exlog_user_registration {
    public static function setup_user_registration() {
        if (exlog_get_option("exlog_disble_user_registration") == "on") {
            update_option('users_can_register', false);
        } else {
            $self = new self();
            // Turn on default registration for all users
            update_option('users_can_register', true);
            update_option('default_role', exlog_get_option('exlog_default_wp_registration_role'));

            add_filter('registration_errors', array($self, "before_user_is_registered"), 10, 3);
            add_filter('register_form', array($self, "add_additional_fields"));
        }
    }
    
    public static function add_user_to_external_db($errors) {
        // Collate fields and values to add

        // Run query
        $result = exlog_add_new_user_to_external_db($_POST['first_name']);

        if (!$result) {
            $errors->add( 'exlog_insert_error', __( '<strong>Registration Error (EXLOG 554)</strong>: Unable to register.', 'crf' ) );
        }

        // If query fails return error
        return $errors;
    }

    public function before_user_is_registered($errors, $sanitized_user_login, $user_email) {
        // If no errors from user existing in WP DB - check External DB
        if (count($errors->get_error_codes()) == 0) {
            //    Need to check if username exists
            if (exlog_does_value_exists_in_field(exlog_get_option('exlog_dbstructure_username'), $sanitized_user_login)) {
                $errors->add('username_exists', "The username is already registered to another user.");

            } else if (exlog_does_value_exists_in_field(exlog_get_option('exlog_dbstructure_email'), $user_email)) {
                $errors->add('email_exists', "The e-mail is already registered to another user.");
            } else if (empty( $_POST['first_name'] ) ) {
                $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must add your First Name.', 'crf' ) );
            }
        }

        if (count($errors->get_error_codes()) == 0) {
            $errors = Exlog_user_registration::add_user_to_external_db($errors);
        }

        return $errors;
    }

    public function add_additional_fields() {
        foreach (exlog_get_option('exlog_additional_fields_field_mapping') as $additional_field) {
            if ($additional_field['external_login_option_show_field_in_registration'] == "on") {
                $exlog_registration_form_element_name = $additional_field['exlog_additional_field_name'];
                $exlog_registration_form_element_label = $additional_field['exlog_additional_field_label'];
                $exlog_registration_form_element_required = $additional_field['external_login_option_required_field'] == "on";
                include EXLOG_PATH_PLUGIN_VIEWS . '/registration/registration_form_elements/text.php';
            }
        }

    }
}