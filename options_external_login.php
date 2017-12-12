<?php
/* Add Custom Admin Menu */
add_action( 'admin_menu', 'exlog_create_options_menu' );
add_action( 'admin_init', 'exlog_register_options_menu_settings');

function exlog_register_options_menu_settings() {
    global $EXLOG_PLUGIN_DATA;
    global $EXLOG_OPTION_FIELDS;

    foreach ($EXLOG_OPTION_FIELDS as $form_field) {
      register_setting( $EXLOG_PLUGIN_DATA['slug'] . '-option-group', $form_field["field_slug"] );
    }
};

function exlog_create_options_menu() {
    global $EXLOG_PLUGIN_DATA;
    add_options_page( $EXLOG_PLUGIN_DATA['name'] . ' Options', $EXLOG_PLUGIN_DATA['name'], 'manage_options', $EXLOG_PLUGIN_DATA['slug'] . '-identifier', 'exlog_generate_options_view' );
}

function exlog_generate_options_view() {
    global $EXLOG_PLUGIN_DATA;
    global $EXLOG_OPTION_FIELDS;

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    }
    ?>

  <div>
      <?php screen_icon(); ?>
    <h2><?php echo $EXLOG_PLUGIN_DATA['name'] ?> Options</h2>

    <form method="post" action="options.php">
        <?php
        settings_fields( $EXLOG_PLUGIN_DATA['slug'] . '-option-group' );
        do_settings_fields( $EXLOG_PLUGIN_DATA['slug'] . '-option-group', '' );
        ?>

        <?php foreach ($EXLOG_OPTION_FIELDS as $form_field) : ?>
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
