<p>
    <label for="first_name"><?php echo $exlog_registration_form_element_label; ?><br/>
        <input type="text"
               name="<?php echo $exlog_registration_form_element_name; ?>"
               value=""
               class="input"
               <?php if ($exlog_registration_form_element_required) : ?>
                  required
               <?php endif; ?>
        />
    </label>
</p>