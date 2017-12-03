<?php
/* Add Custom Admin Menu */
add_action( 'admin_menu', 'external_login_menu' );
add_action( 'admin_init', 'register_external_login_settings');

function register_external_login_settings() {
    register_setting( 'external_login_option-group', 'external_login_option_db_host' );
};

function external_login_menu() {
    add_options_page( 'External Login Options', 'External Login', 'manage_options', 'external-login-identifier', 'custom_external_login_options' );
}

function custom_external_login_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    }
    ?>

  <div>
      <?php screen_icon(); ?>
    <h2>External Login Options</h2>

    <form method="post" action="options.php">
        <?php
        settings_fields( 'external_login_option-group' );
        do_settings_fields( 'external_login_option-group', '' );
        ?>

      <p>Database Host</p>
      <input type="text" name="external_login_option_db_host" value="<?php echo get_option('external_login_option_db_host'); ?>" />

        <?php
        submit_button();
        ?>
    </form>
  </div>
    <?php
}
?>