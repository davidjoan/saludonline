<?php slot('title') ?>
  <?php echo $form->isNew() ? 'Add' : 'Edit' ?> Patient
<?php end_slot() ?>

<?php include_component('Crud', 'edit', array('form' => $form)) ?>
