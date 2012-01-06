<table class="buttons_container">
  <tr>
    <td align="right">
      <table class="buttons">
        <tr>
          <?php if (has_slot('buttons')): ?>
            <?php include_slot('buttons') ?>
          <?php endif; ?>
          
          <?php if ($buttons['add']): ?>
            <?php if (isset($object) && $object): ?>
              <td><?php echo div_button_to('Add', sprintf('@%s_new?parent_slug=%s', $usClass, $object->getSlug())) ?></td>
            <?php else: ?>
              <td><?php echo div_button_to('Add', sprintf('@%s_new', $usClass)) ?></td>
            <?php endif ?>
          <?php endif; ?>
          
          <?php if ($buttons['edit']): ?>
            <td><?php echo div_button_to_get_url('Edit', sprintf('@%s_edit?slug=slug', $usClass), array('slug' => array('id' => $usClass.'_slug', 'list' => true, 'validate' => true, 'single' => true))) ?></td>
          <?php endif; ?>
          
          <?php if ($buttons['delete']): ?>
            <td><?php echo div_button_to_get_url('Delete', sprintf('@%s_delete?slug=slug', $usClass), array('slug' => array('id' => $usClass.'_slug', 'list' => true, 'validate' => true, 'to_delete' => true))) ?></td>
          <?php endif; ?>
        </tr>
      </table>
    </td>
  </tr>
</table>
