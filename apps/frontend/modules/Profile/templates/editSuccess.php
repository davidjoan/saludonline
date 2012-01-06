<div class="post">
<?php include_component('Generic', 'formulario', array
      (
        'form'          => $form,
        'action_uri'    => ($form->isNew())?url_for('@profile_new'):url_for('@profile_edit?slug='.$object->getSlug()),
        'submit'        => ($form->isNew())?'Registrar':'Actualizar',
        'with_title'    => ($form->isNew())?'Nuevo Perfil':'Editar Perfil'
      ))
?>
</div>