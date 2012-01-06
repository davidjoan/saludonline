	<script type="text/javascript">
		$(document).ready(function() {
			$("a[rel=resource_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over'
				})
			});
	</script>
<div class="post">
  <blockquote>
    <p>En esta sección podras cargar tus imagenes como radiografias, ecograficas, analisis, etc.</p>
    <p class="align-right"> - Equipo de Salud Online</p>
  </blockquote>

  <p><?php echo link_to('Añadir una Imagen', '@resource_new', array('class' => 'more'))?></p>
</div>
<ul class="archive">
<?php foreach($objects as $resource): ?>
<?php include_partial('Resource/resume', array('resource' =>  $resource));?>
<?php endforeach; ?>
</ul>