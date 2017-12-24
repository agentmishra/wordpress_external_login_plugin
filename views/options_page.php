<div>
    <?php screen_icon(); ?>
    <h2><?php echo $EXLOG_PLUGIN_DATA['name'] ?> Options</h2>

    <form method="post" action="options.php">
        <?php
        settings_fields( $EXLOG_PLUGIN_DATA['slug'] . '-option-group' );
        do_settings_fields( $EXLOG_PLUGIN_DATA['slug'] . '-option-group', '' );
        ?>

        <?php foreach ($EXLOG_OPTION_FIELDS as $form_section) : ?>
            <h3><?php echo $form_section['section_name'] ?></h3>
            <p><?php echo $form_section['section_description'] ?></p>

            <?php foreach ($form_section['section_fields'] as $form_field) : ?>
                <h4><?php echo $form_field["field_name"]; ?></h4>
                <p><?php echo $form_field["field_description"]; ?></p>
                <input
                    type="text"
                    name="<?php echo $form_field["field_slug"]; ?>"
                    value="<?php echo get_option($form_field["field_slug"]); ?>"
                />
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?php submit_button(); ?>
    </form>
</div>