<?php use_stylesheet($styles) ?>
<?php use_javascript('general/crud.js') ?>

<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>


<div class="form_edit">   
  <form
    name="<?php echo $form->getName() ?>" 
    action="<?php echo $action_url ?>" 
    method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>
    autocomplete="<?php echo $autocomplete ?>"
  >
    <table class="form">
      <?php if ($with_title): ?>
        <tr>
          <th colspan="2" class="title">Info</th>
        </tr>
      <?php endif ?>
      
      <?php if (!has_slot('form')): ?>
        <?php echo $form ?>
      <?php else: ?>
        <?php include_slot('form') ?>
      <?php endif ?>
      
      <?php if ($form->getOption('required_labels')): ?>
        <tr>
          <td colspan="2" class="required warning">
            * = Required Field
          </td>
        </tr>
      <?php endif ?>
      
      <tr>
        <td colspan="2" class="buttons">
          <br/>
          <input type="submit" value="<?php echo $submit ?>" class="button button_submit"/>
          <?php if (has_slot('form_buttons')): ?>
            <?php include_slot('form_buttons') ?>
          <?php endif; ?>
          <input id="form_submit" type="submit" value="Save" style="display: none;"/> <!-- Just for testing compatibility -->
        </td>
      </tr>
    </table>
  </form>
</div>

<?php echo javascript_tag('giveEditToggle()') ?>
