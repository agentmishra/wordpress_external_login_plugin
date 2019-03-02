<?php
function exlog_auth( $user, $username, $password ){
    // Make sure a username and password are present for us to work with
    if($username == '' || $password == '') return;

    $response = exlog_auth_query($username, $password);

    $roles = exlog_map_role($response['role']);

    $block_access_due_to_role = true;
    foreach ($roles as $role) {
        if ($role != EXLOG_ROLE_BLOCK_VALUE) {
            $block_access_due_to_role = false;
        }
    }

    // If a user was found
    if ($response) {

        // If role is blocking user access
        if( $block_access_due_to_role ) {
            $user = new WP_Error( 'denied', __("You are not allowed access") );

        // If user was NOT authenticated
        } else if( !($response["exlog_authenticated"]) ) {
            // User does not exist, send back an error message
            $user = new WP_Error( 'denied', __("Invalid username or password") );

        // If user was authenticated
        } else if( $response["exlog_authenticated"] ) {
            // External user exists, try to load the user info from the WordPress user table
            $userobj = new WP_User();
            $user = $userobj->get_data_by( 'login', $response['username'] ); // Does not return a WP_User object 🙁
            $user = new WP_User($user->ID); // Attempt to load up the user with that ID

            $userdata = array(
                'user_login' => $response['username'],
                'first_name' => $response['first_name'],
                'last_name'  => $response['last_name'],
                'user_pass'  => $password,
                'role'       => $roles[0],
                'user_email' => $response['email'],
            );

            // If user does not exist
            if( $user->ID == 0 ) {
                // Setup the minimum required user information

                $new_user_id = wp_insert_user( $userdata ); // A new user has been created

                // Load the new user info
                $user = new WP_User ($new_user_id);
            } else {
                $userdata['ID'] = $user->ID;

                add_filter( 'send_password_change_email', '__return_false' ); // Prevent password update e-mail

                wp_update_user( $userdata );
            }

            $user->set_role($roles[0]); // Wipe out old roles

            // Add roles to user if more than one
            foreach ($roles as $role) {
                $user->add_role($role);
            }
        }
    }

    // Whether to disable login fallback with the local Wordpress version of the username and password
    // Prevents local login if:
    // - Disable local login  is set in the admin area
    // - OR
    // - The user was found but the password was rejected
    if (exlog_get_option('external_login_option_disable_local_login') == "on" || is_wp_error($user)) {
        remove_action('authenticate', 'wp_authenticate_username_password', 20);
    }

    return $user;
}

if (exlog_get_option("external_login_option_enable_external_login") == "on") {
    add_filter('authenticate', 'exlog_auth', 10, 3);
}
