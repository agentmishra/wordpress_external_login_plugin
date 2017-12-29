<?php
  $exlog_roles = array_reverse(exlog_get_roles());

  var_dump(get_option($form_field["field_slug"]));

  $exlog_external_roles = array(
    array(
      "external_db_role" => "UNSPECIFIED",
      "wordpress_role" => "",
    )
  );
?>



<div class="roles">
  <?php foreach ($exlog_external_roles as $exlog_external_role) : ?>
    <div class="role">
      <input
        class="external_role"
        type="text"
        value="<?php echo $exlog_external_role['external_db_role']; ?>"
        readonly
      >

      <select class="wordpress_role" name="<?php echo "REFFFFFFFFFFFFFFFFFFF"; ?>">
          <?php foreach ($exlog_roles as $key => $value) : ?>
              <option
                  <?php if ("SOMETHING" == $key) :?>
                      selected="selected"
                  <?php endif; ?>
                  value="<?php echo $key; ?>"><?php echo $value; ?>
              </option>
          <?php endforeach; ?>
      </select>
    </div>
  <?php endforeach; ?>
</div>

<div class="add_more">
  <p class="description">Click to add another key value pair:</p>
  <input class="add_button" type="button" value="+"/>
</div>

<input
  class="exlog_custom_roles"
  type="hidden"
  name="<?php echo $form_field["field_slug"]; ?>"
  value="<?php echo get_option($form_field["field_slug"]); ?>"
/>
