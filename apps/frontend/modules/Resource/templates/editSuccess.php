<div class="post">
<?php include_component('Generic', 'formulario', array
      (
        'form'          => $form,
        'action_uri'    => ($form->isNew())?url_for('@resource_new'):url_for('@resource_edit?slug='.$object->getSlug()),
        'submit'        => ($form->isNew())?'Registrar':'Actualizar',
        'with_title'    => ($form->isNew())?'Nueva Imagen':'Editar Imagen'
      ))
?>
</div>