<div class="option-container">
  <div class="role">
      <input
          class="external_role"
          type="text"
          value="<?php echo $exlog_external_role[$EXLOG_JSON_KEY_EXTERNAL_VALUE]; ?>"
          name="<?php echo $exlog_external_role[$EXLOG_JSON_KEY_EXTERNAL_NAME]; ?>"
      >

      <select class="wordpress_role" name="<?php echo $exlog_external_role[$EXLOG_JSON_KEY_WORDPRESS_NAME]; ?>">
          <?php foreach ($EXLOG_WORDPRESS_AVAILABLE_ROLES as $key => $value) : ?>
              <option
                  <?php if ($exlog_external_role[$EXLOG_JSON_KEY_WORDPRESS_VALUE] == $key) :?>
                      selected="selected"
                  <?php endif; ?>
                  value="<?php echo $key; ?>"
              >
                  <?php echo $value; ?>
              </option>
          <?php endforeach; ?>
      </select>

      <input
          class="remove_role_pairing"
          value="Delete"
          type="button"
      />

  </div>
</div>