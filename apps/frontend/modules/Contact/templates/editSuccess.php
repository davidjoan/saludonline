<div class="post">
<?php include_component('Generic', 'formulario', array
      (
        'form'          => $form,
        'action_uri'    => ($form->isNew())?url_for('@contact_new'):url_for('@contact_edit?slug='.$object->getSlug()),
        'submit'        => ($form->isNew())?'Registrar':'Actualizar',
        'with_title'    => ($form->isNew())?'Nuevo Contacto':'Editar Contacto'
      ))
?>
</div>