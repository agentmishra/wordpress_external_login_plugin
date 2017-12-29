<div class="exlog_options_page">
    <?php screen_icon(); ?>
    <h2><?php echo $EXLOG_PLUGIN_DATA['name'] ?> Options</h2>

    <form method="post" action="options.php">
        <?php
          settings_fields( $EXLOG_PLUGIN_DATA['slug'] . '-option-group' );
          do_settings_fields( $EXLOG_PLUGIN_DATA['slug'] . '-option-group', '' );
        ?>

        <?php foreach ($EXLOG_OPTION_FIELDS as $form_section) : ?>
            <div class="options_section_container">
              <div class="options_section <?php echo $form_section['section_slug']; ?>">
                <h3><?php echo $form_section['section_name'] ?></h3>
                <p><?php echo $form_section['section_description'] ?></p>
                <hr>

                <?php foreach ($form_section['section_fields'] as $form_field) : ?>
                    <?php
                        if ($form_field["type"] == "text") :
                            include $EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/text_field.php';
                        elseif ($form_field["type"] == "select") :
                            include $EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/select_field.php';
                        elseif ($form_field["type"] == "checkbox") :
                            include $EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/checkbox_field.php';
                        elseif ($form_field["type"] == "roles") :
                            include $EXLOG_PATH_PLUGIN_VIEWS . '/form_elements/roles_fields_builder.php';
                        endif;
                    ?>
                <?php endforeach; ?>

                <?php submit_button(); ?>
              </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>
