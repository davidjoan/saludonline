<div class="post-iframe">
  <?php include_partial('General/alerts')?>
  <h4>Editar Talla</h4>
  <?php include_component('Generic', 'formulario', array
      (
        'form'          => $form,
        'action_uri'    => url_for('@height_edit?slug='.$object->getSlug()),
        'styles_folder' => 'log',
        'submit'        => 'Actualizar',
        'with_title'    => false,
        'with_back'     => false
      ))
  ?>
</div>