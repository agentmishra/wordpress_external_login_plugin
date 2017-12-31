<?php
  $exlog_roles = array_reverse(exlog_get_roles());
  reset($exlog_roles);
  $exlog_first_role = key($exlog_roles);

  $EXLOG_EXTERNAL_ROLE_PREFIX = "exlog_role_external_";
  $EXLOG_WORDPRESS_ROLE_PREFIX = "exlog_role_wordpress_";

  $EXLOG_UNSPECIFIED_EXTERNAL_ROLE_VALUE = "UNSPECIFIED";
  $EXLOG_UNSPECIFIED_EXTERNAL_ROLE_NAME = $EXLOG_EXTERNAL_ROLE_PREFIX . strtolower($EXLOG_UNSPECIFIED_EXTERNAL_ROLE_VALUE);
  $EXLOG_UNSPECIFIED_WORDPRESS_ROLE_NAME = $EXLOG_WORDPRESS_ROLE_PREFIX . strtolower($EXLOG_UNSPECIFIED_EXTERNAL_ROLE_VALUE);
  $EXLOG_UNSPECIFIED_WORDPRESS_ROLE_VALUE = $exlog_first_role;

  $EXLOG_JSON_KEY_EXTERNAL_VALUE = "external_role_value";
  $EXLOG_JSON_KEY_EXTERNAL_NAME = "external_role_name";
  $EXLOG_JSON_KEY_WORDPRESS_VALUE = "wordpress_role_value";
  $EXLOG_JSON_KEY_WORDPRESS_NAME = "wordpress_role_name";

  $exlog_external_roles = get_option($form_field["field_slug"]);

  if ($exlog_external_roles) {
      $exlog_external_roles = json_decode(urldecode($exlog_external_roles), true);
  } else {
      $exlog_external_roles = array(
          array(
              $EXLOG_JSON_KEY_EXTERNAL_VALUE => $EXLOG_UNSPECIFIED_EXTERNAL_ROLE_VALUE,
              $EXLOG_JSON_KEY_EXTERNAL_NAME => $EXLOG_UNSPECIFIED_EXTERNAL_ROLE_NAME,
              $EXLOG_JSON_KEY_WORDPRESS_VALUE => $EXLOG_UNSPECIFIED_WORDPRESS_ROLE_VALUE,
              $EXLOG_JSON_KEY_WORDPRESS_NAME => $EXLOG_UNSPECIFIED_WORDPRESS_ROLE_NAME,
          )
      );
  };
?>

<div
  class="roles"
  data-exlog-external-role-prefix="<?php echo $EXLOG_EXTERNAL_ROLE_PREFIX; ?>"
  data-exlog-wordpress-role-prefix="<?php echo $EXLOG_WORDPRESS_ROLE_PREFIX; ?>"

  data-exlog-json-key-external-value="<?php echo $EXLOG_JSON_KEY_EXTERNAL_VALUE; ?>"
  data-exlog-json-key-external-name="<?php echo $EXLOG_JSON_KEY_EXTERNAL_NAME; ?>"
  data-exlog-json-key-wordpress-value="<?php echo $EXLOG_JSON_KEY_WORDPRESS_VALUE; ?>"
  data-exlog-json-key-wordpress-name="<?php echo $EXLOG_JSON_KEY_WORDPRESS_NAME; ?>"
>
  <?php foreach ($exlog_external_roles as $exlog_external_role) : ?>
    <div class="role">
      <input
        class="external_role"
        type="text"
        value="<?php echo $exlog_external_role[$EXLOG_JSON_KEY_EXTERNAL_VALUE]; ?>"
        name="<?php echo $exlog_external_role[$EXLOG_JSON_KEY_EXTERNAL_NAME]; ?>"
        <?php if ($exlog_external_role[$EXLOG_JSON_KEY_EXTERNAL_VALUE] == $EXLOG_UNSPECIFIED_EXTERNAL_ROLE_VALUE) : ?>
          readonly
        <?php endif; ?>
      >

      <select class="wordpress_role" name="<?php echo $exlog_external_role[$EXLOG_JSON_KEY_WORDPRESS_NAME]; ?>">
          <?php foreach ($exlog_roles as $key => $value) : ?>
              <option
                  <?php if ($exlog_external_role[$EXLOG_JSON_KEY_WORDPRESS_VALUE] == $key) :?>
                      selected="selected"
                  <?php endif; ?>
                  value="<?php echo $key; ?>"><?php echo $value; ?>
              </option>
          <?php endforeach; ?>
      </select>

      <input
        class="remove_role_pairing"
        value="Delete"
      <?php if ($exlog_external_role[$EXLOG_JSON_KEY_EXTERNAL_VALUE] == $EXLOG_UNSPECIFIED_EXTERNAL_ROLE_VALUE) : ?>
        type="hidden"
      <?php else : ?>
        type="button"
      <?php endif; ?>
      />

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
