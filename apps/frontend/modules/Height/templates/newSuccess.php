<div class="post-iframe">
  <?php include_partial('General/alerts')?>
  <h4>Registrar Talla</h4>
  <?php include_component('Generic', 'formulario', array
      (
        'form'          => $form,
        'action_uri'    => url_for('@height_new?slug='.$object->getProfile()->getSlug()),
        'styles_folder' => 'log',
        'submit'        => 'Registrar',
        'with_title'    => false,
        'with_back'     => false
      ))
  ?>
</div>