# External Login

See readme.txt for the main information for the plugin.
This is done to save duplication as readme.txt is required for WordPress plugin repository.

## Hooks

### Action: exlog_hook_action_authenticated
This hook is run after the user has been authenticated from the external database.

This will not run if the user is authenticated from the local WordPress database.

Below is an example of code that could be added to your `functions.php` file to delete a user from the external database after they have logged in for the first time.
```
/**
 * Example function to do something after External Login has authenticated a user
 *
 * In this case we are deleting the user from the external database
 *
 * WP User Object $wp_user The WordPress user object for the authenticated user.
 *
 * Array $exlog_user_data An associative array of user data generated when attempting to authenticate the user
 */
function my_function_to_do_something_after_authentication($wp_user, $exlog_user_data) {
  // Uses the data provided to the plugin to create the database object and data required for a query
  $db_data = exlog_get_external_db_instance_and_fields('mysql');

  // A query of your choice
  $rows = $db_data["db_instance"]->delete(
    esc_sql($db_data["dbstructure_table"]),
    array( esc_sql($db_data["dbstructure_username"]) => esc_sql($exlog_user_data['user_login']) )
  );

  // Checking if the user was deleted
  if ($rows) {
    error_log('User Successfully deleted from external database');
  } else {
    error_log('Unable to delete user from external database');
  }
}

add_action('exlog_hook_action_authenticated', 'my_function_to_do_something_after_authentication', 10, 2);
```

## Special Thanks
A special thank you to Ben Lobaugh for a [great article](https://ben.lobaugh.net/blog/7175/wordpress-replace-built-in-user-authentication) which I used heavily for this plugin.

## Future Plans
- Add Social Login with:
    - Facebook
    - Google
    - Github
- Ability to prepend user names in WP with a string to separate WP users from those generated with external login
- Add a custom login screen

## Deploy to WordPress
This is a note to self. This process and code needs integrating into the plugin itself.
A copy of the deploy script is in the repo for reference but needs running from a directory above it (see step 6).

1) Modify the version number in external-login.php
1) Modify readme.txt "Tested up to" version
1) Modify readme.txt version
1) Modify readme.txt == Changelog ==
1) Modify readme.txt == Upgrade Notice ==
1) Tag git commit with respective version number
1) In repo directory execute `./deploy.sh`
