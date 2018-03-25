<div
  class="exlog_options_page"
>
    <?php screen_icon(); ?>
    <h2><?php echo BuiltPluginData::Instance()->get_plugin_data()['name'] ?> Options</h2>

    <form method="post" action="options.php">
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

</div>
