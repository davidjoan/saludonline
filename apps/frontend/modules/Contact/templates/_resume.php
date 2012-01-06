  <li>
    <div class="post-title"><?php echo link_to($contact->getPrefixStr().' '.$contact->getFirstname().' '.$contact->getLastname()  , '@contact_edit?slug='.$contact->getSlug()); ?></div>
    <div class="post-details">
    <?php echo link_to('Editar'  , '@contact_edit?slug='.$contact->getSlug()); ?> Información del Contacto
      <?php if($contact->getGender()): ?>
        <b>| Genero</b> <?php echo $contact->getGenderStr(); ?>
      <?php endif;?>        
      <?php if($contact->getEmail()): ?>
      <b>| Email:</b> <?php echo $contact->getEmail(); ?>
      <?php endif;?>        
      <?php if($contact->getHomePhone()): ?>
      <b>| Teléfono Casa:</b> <?php echo $contact->getHomePhone(); ?>
      <?php endif;?>        
      <?php if($contact->getOfficePhone()): ?>
      <b>| Teléfono Oficina:</b> <?php echo $contact->getOfficePhone(); ?>
      <?php endif;?>        
      <?php if($contact->getMobilePhone()): ?>
      <b>| Celular:</b> <?php echo $contact->getMobilePhone(); ?>
      <?php endif;?>        
      <?php if($contact->getRpm()): ?>
      <b>| Rpm:</b> <?php echo $contact->getRpm(); ?>
      <?php endif;?>        
      <?php if($contact->getRpc()): ?>
      <b>| Rpc:</b> <?php echo $contact->getRpc(); ?>
      <?php endif;?>              
      <?php if($contact->getFax()): ?>
      <b>| Fax:</b> <?php echo $contact->getFax(); ?>
      <?php endif;?>            
      <?php if($contact->getNextel()): ?>
      <b>| Nextel:</b> <?php echo $contact->getNextel(); ?>
      <?php endif;?>        
      <?php if($contact->getAddressHome()): ?>
      <b>| Dirección Casa:</b> <?php echo $contact->getAddressHome(); ?>
      <?php endif;?>        
      <?php if($contact->getAddressWork()): ?>
      <b>| Dirección Trabajo:</b> <?php echo $contact->getAddressWork(); ?>
      <?php endif;?>              
      <br/>
      Registrado el <?php echo $contact->getFormattedCreatedAt(); ?> | <?php echo link_to('Eliminar', '@contact_delete?slug='.$contact->getSlug(), 'confirm=Realmente quieres eliminar este contacto?'); ?>
    </div>
  </li>