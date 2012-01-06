  <li>
    <div class="post-title"><?php echo link_to('Dr(a). '.$doctor->getFirstname().' '.$doctor->getLastname()  , '@doctor_edit?slug='.$doctor->getSlug()); ?></div>
    <div class="post-details"><?php echo link_to('Editar'  , '@doctor_edit?slug='.$doctor->getSlug()); ?> Información del Doctor
      <?php if($doctor->getSpecialtyId() ): ?>
        <b>| Especialidad: </b> <?php echo $doctor->getSpecialty()->getName(); ?>
      <?php endif;?>        
      <?php if($doctor->getGender()): ?>
        <b>| Genero</b> <?php echo $doctor->getGenderStr(); ?>
      <?php endif;?>        
      <?php if($doctor->getEmail()): ?>
      <b>| Email:</b> <?php echo $doctor->getEmail(); ?>
      <?php endif;?>        
      <?php if($doctor->getHomePhone()): ?>
      <b>| Teléfono Casa:</b> <?php echo $doctor->getHomePhone(); ?>
      <?php endif;?>        
      <?php if($doctor->getOfficePhone()): ?>
      <b>| Teléfono Oficina:</b> <?php echo $doctor->getOfficePhone(); ?>
      <?php endif;?>        
      <?php if($doctor->getMobilePhone()): ?>
      <b>| Celular:</b> <?php echo $doctor->getMobilePhone(); ?>
      <?php endif;?>                    
      <?php if($doctor->getFax()): ?>
      <b>| Fax:</b> <?php echo $doctor->getFax(); ?>
      <?php endif;?>              
      <?php if($doctor->getAllHospitalNames() <> ''): ?>
      <b>| Hospitales:</b> <?php echo $doctor->getAllHospitalNames(); ?>
      <?php endif;?>
      <br/>
      Registrado el <?php echo $doctor->getFormattedCreatedAt(); ?> | <?php echo link_to('Eliminar', '@doctor_delete?slug='.$doctor->getSlug(), 'confirm=Realmente quieres eliminar este doctor?'); ?>
    </div>
  </li>