<div class="post">
  <?php if($redirect): ?>
    <h3>Perfil de <?php echo link_to($profile->getFirstname().' '.$profile->getLastname(), '@profile_panel?slug='.$profile->getSlug()); ?></h3>
    <p class="post-info">
      <?php echo link_to('Detalle'  , '@profile_panel?slug='.$profile->getSlug()); ?>
      <?php echo link_to('Editar'   , '@profile_edit?slug='.$profile->getSlug()); ?>
      <?php echo link_to('Imprimir' , '@profile_print?slug='.$profile->getSlug()); ?>
      <?php echo link_to('Eliminar' , '@profile_delete?slug='.$profile->getSlug(), 'confirm=Realmente quieres eliminar este perfil?'); ?>
    </p>
  <?php else: ?>
    <h3>Perfil de <?php echo $profile->getFirstname().' '.$profile->getLastname(); ?></h3>
  <?php endif; ?>
  <p>
    <?php if($profile->getImage()):?>
      <?php echo link_to(image_tag(sfConfig::get('app_profile_path').'/'.$profile->getImage(), array('size' => '100x120', 'alt' => $profile->getFirstname(), 'class' => 'float-left')), '@profile_edit?slug='.$profile->getSlug()); ?>
    <?php endif; ?>
      <b>DNI:</b> <?php echo $profile->getDni(); ?><br/>
      <b>Nombres:</b> <?php echo $profile->getFirstname(); ?><br/>
      <b>Apellidos:</b> <?php echo $profile->getLastname(); ?><br/>
      <?php if($profile->getDateOfBirth()): ?>
      <b>Fecha de Nacimiento:</b> <?php echo $profile->getFormattedDateOfBirth(); ?><br/>
      <?php endif;?>
      <?php if($profile->getGender()): ?>
      <b>Genero:</b> <?php echo $profile->getGenderStr(); ?><br/>
      <?php endif;?>
      <?php if($profile->getBloodType()): ?>
      <b>Tipo de Sangre:</b> <?php echo $profile->getBloodTypeStr(); ?><br/>
      <?php endif;?>
      <?php if($profile->getMaritalStatus()): ?>
      <b>Estado Civil:</b> <?php echo $profile->getMaritalStatusStr(); ?><br/>
      <?php endif;?>
  </p>
</div>