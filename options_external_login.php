<?php
/* Add Custom Admin Menu */
add_action( 'admin_menu', 'external_login_menu' );
add_action( 'admin_init', 'register_external_login_settings');

function register_external_login_settings() {
    global $ex_login_option_fields;
    foreach ($ex_login_option_fields as $form_field) {
      register_setting( 'external_login_option-group', $form_field["field_slug"] );
    }
};

function external_login_menu() {
    add_options_page( 'External Login Options', 'External Login', 'manage_options', 'external-login-identifier', 'custom_external_login_options' );
}

function custom_external_login_options() {
    global $ex_login_option_fields;

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

        <?php foreach ($ex_login_option_fields as $form_field) : ?>
          <h4><?php echo $form_field["field_name"]; ?></h4>
          <p><?php echo $form_field["field_description"]; ?></p>
          <input
            type="text"
            name="<?php echo $form_field["field_slug"]; ?>"
            value="<?php echo get_option($form_field["field_slug"]); ?>"
          />
        <?php endforeach; ?>

        <?php
        submit_button();
        ?>
    </form>
  </div>
    <?php
}
?>