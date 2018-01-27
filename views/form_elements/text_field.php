<div
  class="option-container"
  data-exlog-conditionals="<?php echo htmlspecialchars(json_encode($form_field["conditionals"])); ?>"
>
  <h4><?php echo $form_field["field_name"]; ?></h4>
  <p><?php echo $form_field["field_description"]; ?></p>
  <input
      type="text"
      name="<?php echo $form_field["field_slug"]; ?>"
      value="<?php echo get_option($form_field["field_slug"]); ?>"
  />
</div>