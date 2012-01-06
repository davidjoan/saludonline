<?php $is_selected    = $sf_user->getCurrentRouteName() == $uri; ?>
<?php $current_string = ($is_selected)? "id='current'" : ''; ?>

<li <?php echo $current_string;?>>
  <?php echo link_to($title, $uri);?>
</li>