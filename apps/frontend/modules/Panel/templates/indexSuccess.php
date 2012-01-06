<div class="post">
  <?php if($company->getMessage()): ?>
  <blockquote>
    <p><?php echo $company->getMessage(); ?></p>
    <p class="align-right"> - Equipo de Salud Online</p>
  </blockquote>
  <?php endif; ?>

  <p><?php echo link_to('Añadir un Perfil', '@profile_new', array('class' => 'more'))?></p>
</div>
<?php foreach($profiles as $profile): ?>
<?php include_partial('Profile/resume', array('profile' =>  $profile, 'redirect' => true));?>
<?php endforeach; ?>