<?php $function = sprintf('submitForm("%s")', $sf_params->get('usClass')) ?>

<table class="buttons_container">
  <tr>
    <td align="<?php echo $right ? 'right' : 'left' ?>">
      <table class="buttons">
        <tr>
          <td><?php echo div_button_to_function($object->isNew() ? 'Save' : 'Update', $function, array('id' => 'Save')) ?></td>
          <td><?php echo div_button_to('Cancel', get_entrance_route()) ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
