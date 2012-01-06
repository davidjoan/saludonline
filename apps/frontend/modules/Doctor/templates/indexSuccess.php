<div class="post">
  <blockquote>
    <p>En esta sección podras registrar a los doctores con los que as recibido o estas recibiendo algún tratamiento.</p>
    <p class="align-right"> - Equipo de Salud Online</p>
  </blockquote>

  <p><?php echo link_to('Añadir un Doctor', '@doctor_new', array('class' => 'more'))?></p>
</div>
<ul class="archive">
<?php foreach($objects as $doctor): ?>
<?php include_partial('Doctor/resume', array('doctor' =>  $doctor));?>
<?php endforeach; ?>
</ul>