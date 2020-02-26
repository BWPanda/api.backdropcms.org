<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * *** CHANGES: ***
 * - Changed $title tag to H2 and added an ID.
 */
?>

<?php if (!empty($title)): ?>
  <h2 id="<?php print $title; ?>"><?php print $title; ?></h2>
<?php endif; ?>
<?php foreach ($rows as $row_count => $row): ?>
  <div <?php if (!empty($row_classes[$row_count])) { print 'class="' . implode(' ', $row_classes[$row_count]) . '"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
