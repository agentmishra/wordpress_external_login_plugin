<?php
  $exlog_roles = exlog_get_roles();

  $exlog_external_roles = array(
    array(
      "external_db_role" => "UNSPECIFIED",
      "wordpress_role" => "",
      "description" => "The default option to be used if the external role has not been assigned a WordPress role."
    )
  );
?>

<?php foreach ($exlog_external_roles as $exlog_external_role) : ?>
  <h4><?php echo $exlog_external_role['external_db_role'] . " Role"; ?></h4>
  <?php if ($exlog_external_role['description'] !== "") :?>
    <p> <?php echo $exlog_external_role['description']; ?></p>
   <?php endif; ?>
  <select name="<?php echo "field_slug"; ?>">
      <?php foreach ($exlog_roles as $key => $value) : ?>
          <option
              <?php if ("SOMETHING" == $key) :?>
                  selected="selected"
              <?php endif; ?>
              value="<?php echo $key; ?>"><?php echo $value; ?>
          </option>
      <?php endforeach; ?>
  </select>
<?php endforeach; ?>
