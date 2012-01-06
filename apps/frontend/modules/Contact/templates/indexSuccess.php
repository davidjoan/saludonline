<div class="post">
  <blockquote>
    <p>En esta sección podras registrar a tus contactos en caso de emergencias.</p>
    <p class="align-right"> - Equipo de Salud Online</p>
  </blockquote>

  <p><?php echo link_to('Añadir un Contacto', '@contact_new', array('class' => 'more'))?></p>
</div>
<ul class="archive">
<?php foreach($objects as $contact): ?>
<?php include_partial('Contact/resume', array('contact' =>  $contact));?>
<?php endforeach; ?>
</ul>