<?php
  $EXLOG_UNSPECIFIED_ROLE_STRING = "UNSPECIFIED";

  $exlog_roles = array_reverse(exlog_get_roles());

  $exlog_external_roles = get_option($form_field["field_slug"]);

  if ($exlog_external_roles) {
      $exlog_external_roles = json_decode(urldecode($exlog_external_roles), true);
  } else {
      $exlog_external_roles = array(
          array(
              "external_role" => $EXLOG_UNSPECIFIED_ROLE_STRING,
              "wordpress_role" => "",
          )
      );
  };


?>



<div class="roles">
  <?php foreach ($exlog_external_roles as $exlog_external_role) : ?>
    <div class="role">
      <input
        class="external_role"
        type="text"
        value="<?php echo $exlog_external_role['external_role']; ?>"
        <?php if ($exlog_external_role['external_role'] == $EXLOG_UNSPECIFIED_ROLE_STRING) : ?>
          readonly
        <?php endif; ?>
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
