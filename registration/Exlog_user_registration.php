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

            add_action('password_reset', array($self, "before_password_reset"), 10, 2 );
            add_filter('registration_errors', array($self, "before_user_is_registered"), 10, 3);
            add_filter('register_form', array($self, "add_additional_fields"));
        }
    }

    public static function before_password_reset($user, $new_password) {
        $algorithm = exlog_get_option("external_login_option_hash_algorithm");

        if ($algorithm == "none") {
            $hashed_password = $new_password;
        } else if ($algorithm == "phpass") {
            $hashed_password = wp_hash_password($new_password);
        } else if ($algorithm == "phpcrypt") {
            $hashed_password = crypt($new_password);
        } else if ($algorithm == "bcrypt") {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $username = get_userdata($user->ID)->user_login;

        $successfully_updated_password = exlog_update_password_in_external_db($username, $hashed_password);

        // If external login cannot update the password, prevent password reset
        if (!$successfully_updated_password) {
            login_header(__('Failed to Reset Password'), '<p style="color:red;" class="message reset-pass" style>' . __('Your password failed to reset. (Exlog error: 465)') . ' <a href="' . esc_url(wp_login_url()) . '">' . __('Try again') . '</a></p>');
            login_footer();
            exit;
        }
    }

    public static function add_user_to_external_db($errors, $username, $email) {
        // Collate fields and values to add

        $insert_array = array();

        // Add username
        $insert_array[exlog_get_option('exlog_dbstructure_username')] = $username;

        // Add email
        $insert_array[exlog_get_option('exlog_dbstructure_email')] = $email;

        // Add first name
        $insert_array[exlog_get_option('exlog_dbstructure_first_name')] = esc_sql($_POST[exlog_get_option('exlog_dbstructure_first_name')]);

        // Add last name
        $insert_array[exlog_get_option('exlog_dbstructure_last_name')] = esc_sql($_POST[exlog_get_option('exlog_dbstructure_last_name')]);

        // Add role
        $insert_array[exlog_get_option('exlog_dbstructure_role')] = esc_sql(exlog_get_option('exlog_default_external_registration_role'));

        // Collate additional field data
        $additional_fields = exlog_get_option('exlog_additional_fields_field_mapping');
        if ($additional_fields && gettype($additional_fields) == 'array') {
            foreach ($additional_fields as $additional_field) {
                if ($additional_field['external_login_option_show_field_in_registration'] == "on") {
                    $insert_array[esc_sql($additional_field['exlog_additional_field_name'])] = esc_sql($_POST[$additional_field['exlog_additional_field_name']]);
                }
            }
        }

        // Run query
        $result = exlog_add_new_user_to_external_db($insert_array);

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
            }
        }

        $additional_fields = exlog_get_option('exlog_additional_fields_field_mapping');
        if (count($errors->get_error_codes()) == 0) {
            if ($additional_fields) {
                foreach ($additional_fields as $additional_field) {
                    if ($additional_field['external_login_option_required_field'] == "on") {
                        if (empty($_POST[$additional_field['exlog_additional_field_name']])) {
                            $errors->add( 'missing_required_field_error', __( '<strong>ERROR</strong>: "' . $additional_field['exlog_additional_field_label'] . '" is a required field.', 'crf' ) );
                        }
                    }
                }
            }
        }

        if (count($errors->get_error_codes()) == 0) {
            $errors = Exlog_user_registration::add_user_to_external_db($errors, $sanitized_user_login, $user_email);
        }

        return $errors;
    }

    public function add_additional_fields() {
        $additional_fields = exlog_get_option('exlog_additional_fields_field_mapping');

        array_unshift($additional_fields,
            array(
                'exlog_additional_field_label' => 'First Name',
                'exlog_additional_field_name' => exlog_get_option('exlog_dbstructure_first_name'),
                'external_login_option_show_field_in_registration' => true
            ),
            array(
                'exlog_additional_field_label' => 'Last Name',
                'exlog_additional_field_name' => exlog_get_option('exlog_dbstructure_last_name'),
                'external_login_option_show_field_in_registration' => true
            )
        );


        if ($additional_fields) {
            foreach ($additional_fields as $additional_field) {
                if ($additional_field['external_login_option_show_field_in_registration'] == "on") {
                    $exlog_registration_form_element_name = $additional_field['exlog_additional_field_name'];
                    $exlog_registration_form_element_label = $additional_field['exlog_additional_field_label'];
                    $exlog_registration_form_element_required = $additional_field['external_login_option_required_field'] == "on";
                    include EXLOG_PATH_PLUGIN_VIEWS . '/registration/registration_form_elements/text.php';
                }
            }
        }

    }
}