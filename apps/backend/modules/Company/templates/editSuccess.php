<?php slot('title') ?>
  <?php echo $form->isNew() ? 'Add' : 'Edit' ?> Company
<?php end_slot() ?>

<?php include_component('Crud', 'edit', array('form' => $form)) ?>
