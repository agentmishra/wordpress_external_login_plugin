<ul
  class="exlog_options_page"
>
    <?php screen_icon(); ?>
  <div class="options_section_outer_container title-section">
    <div class="options_section_container">
      <div class="options_section vert_middle">
        <img src="<?php echo EXLOG_PATH_ASSETS . '/logoClear.svg' ?>">
        <h2><?php echo BuiltPluginData::Instance()->get_plugin_data()['name'] ?> Options</h2>
      </div>
    </div>
    <div class="options_section_container">
      <div class="options_section">
        <h3>Support</h3>
        <hr>
        <ul class="exlog_links">
          <li class="exlog_link">
            Having a problem? Need another feature? Add a <a href="https://wordpress.org/support/plugin/external-login">support request</a>.
          </li>
          <li class="exlog_link">
            Finding this useful? Write a <a href="https://wordpress.org/plugins/external-login/#reviews">review</a> or even <a href="https://www.paypal.me/tombenyon">buy me a beer</a>!
          </li>
        </ul>
      </div>
    </div>
  </div>

    <form class="options_section_outer_container" method="post" action="options.php">
        <?php
          settings_fields( BuiltPluginData::Instance()->get_plugin_data()['slug'] . '-option-group' );
          do_settings_fields( BuiltPluginData::Instance()->get_plugin_data()['slug'] . '-option-group', '' );
        ?>

        <?php foreach (BuiltPluginData::Instance()->get_option_fields() as $form_section) : ?>
            <div class="options_section_container">
              <div class="options_section <?php echo $form_section['section_slug']; ?>">
                <h3><?php echo $form_section['section_name'] ?></h3>
                <p><?php echo $form_section['section_description'] ?></p>
                <hr>

                <?php foreach ($form_section['section_fields'] as $form_field) : ?>
                    <?php
                        if ($form_field["type"] == "text") :
                            include EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/text_field.php';
                        elseif ($form_field["type"] == "select") :
                            include EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/select_field.php';
                        elseif ($form_field["type"] == "checkbox") :
                            include EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/checkbox_field.php';
                        elseif ($form_field["type"] == "roles") :
                            include EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/roles_fields_builder.php';
                        elseif ($form_field["type"] == "button") :
                            include EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/button.php';
                        endif;
                    ?>
                <?php endforeach; ?>

                <?php submit_button(); ?>
              </div>
            </div>
        <?php endforeach; ?>
    </form>

    <?php include EXLOG_PATH_PLUGIN_VIEWS . '/modal.php'; ?>

</ul>
