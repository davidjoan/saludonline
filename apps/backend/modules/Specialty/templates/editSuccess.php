<?php slot('title') ?>
  <?php echo $form->isNew() ? 'Add' : 'Edit' ?> Specialty
<?php end_slot() ?>

<?php include_component('Crud', 'edit', array('form' => $form)) ?>