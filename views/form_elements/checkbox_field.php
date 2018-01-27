<div
  class="option-container"
  data-exlog-conditionals="<?php echo htmlspecialchars(json_encode($form_field["conditionals"])); ?>"
>
  <h4><?php echo $form_field["field_name"]; ?></h4>
  <p><?php echo $form_field["field_description"]; ?></p>
  <input
    id="<?php echo $form_field["field_slug"]; ?>"
    type="checkbox"
    name="<?php echo $form_field["field_slug"]; ?>"
      <?php if (get_option($form_field["field_slug"]) == "on") :?>
        checked
      <?php endif; ?>
  />
</div>