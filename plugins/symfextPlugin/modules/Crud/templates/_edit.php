<?php use_stylesheet(sfConfig::get('sf_app').'/modules/crud.css') ?>
<?php use_javascript('general/crud.js') ?>

<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="crud_edit">
  <div class="title">
    <?php if (has_slot('title')): ?>
      <?php include_slot('title') ?>
    <?php endif ?>
  </div>
  
  <div class="subtitle">
    <?php if (has_slot('subtitle')): ?>
      <?php include_slot('subtitle') ?>
    <?php endif ?>
  </div>
  
  <br/>
  <?php include_partial('Crud/buttons_edit', array('object' => $object, 'right' => true)) ?>
  <br/>

  
  <form 
    name="<?php echo $usClass ?>" 
    action="<?php echo $action_url ?>" 
    method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>
    autocomplete="<?php echo $autocomplete ?>"
  >
    <table class="form">
      <tr>
        <th colspan="2" class="title">Info</th>
      </tr>
      <?php if($form->hasErrors() ): ?>    
      <tr>
          <td colspan="2"> 
          <?php echo $form->renderGlobalErrors(); ?>
          <?php echo $form->renderErrors() ?>
          </td>
          
      </tr>
      <?php endif; ?>   
      
      <?php if (!has_slot('form')): ?>
        <?php echo $form ?>
      <?php else: ?>
        <?php include_slot('form') ?>
      <?php endif; ?>
    </table>
    
    <input id="form_submit" type="submit" value="Save" style="display: none;"/> <!-- Just for testing compatibility -->
  </form>
  
  <?php if ($form->getOption('required_labels')): ?>
    <div class="required warning">* = Required Field</div>
    <br/>
  <?php endif ?>
  
  <?php include_partial('Crud/buttons_edit', array('object' => $object, 'right' => false)) ?>
  <br/>
</div>

<?php echo javascript_tag('giveEditToggle()') ?>
