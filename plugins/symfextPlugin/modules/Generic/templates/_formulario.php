<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php if($with_title):?>
<h3><?php echo ($with_title)?$with_title:''; ?></h3>
<?php endif; ?>
<?php if($form->hasErrors() ): ?>    
    <div class="ui-widget"  style="width: 477px;padding: 10px 25px 0px;">
      <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
      <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
      <strong>Error:</strong> 
       <?php echo $form->renderGlobalErrors(); ?>
       <?php echo $form->renderErrors() ?>
      </p>
      </div>
    </div>    
<?php endif; ?>
      
<form 
    id="form" 
    class="form" 
    name="<?php echo $form->getName() ?>" 
    action="<?php echo $action_url ?>" 
    method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>
    autocomplete="<?php echo $autocomplete ?>">  
  <p class="no-border"><strong></strong></p>
  <?php if (!has_slot('form')): ?>
    <?php echo $form ?>
  <?php else: ?>
    <?php include_slot('form') ?>
  <?php endif ?>
  <p class="no-border">
    <input type="submit" tabindex="5" value="<?php echo $submit; ?>" class="button">
    <?php if($with_back):?>
    <input type="button" tabindex="6" value="Regresar" class="button" onClick="history.back()">
    <?php endif; ?>
    <?php if (has_slot('form_buttons')): ?>
      <?php include_slot('form_buttons') ?>
    <?php endif; ?>
    <input id="form_submit" type="submit" value="Save" style="display: none;"/> <!-- Just for testing compatibility -->
  </p>  
  </form>