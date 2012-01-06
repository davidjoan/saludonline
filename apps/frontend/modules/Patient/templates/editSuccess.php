<div class="post">
<?php include_component('Generic', 'formulario', array
      (
        'form'          => $form,
        'action_uri'    => url_for('@patient_edit'),
        'styles_folder' => 'log',
        'submit'        => 'Actualizar',
        'with_title'    => 'Editar Cuenta de Usuario'
      ))
?>
</div>