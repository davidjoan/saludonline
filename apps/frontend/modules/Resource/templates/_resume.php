<li style="height: 200px;"> 
  <div class="post-details">
    <a title="<?php echo $resource->getName(); ?>" href="<?php echo image_path(sfConfig::get('app_resource_path').'/'.$resource->getPath()); ?>" rel="resource_group">
      <?php echo image_tag($resource->getThumbnailFilePath('path',180 ), array('alt' => $resource->getName(), 'class' => 'float-left')); ?>
    </a>        
    <?php echo link_to('Editar'  , '@resource_edit?slug='.$resource->getSlug()); ?> Información de la imagen<br/>
    <b>Nombre:</b> <?php echo $resource->getName(); ?><br/>
    <b>Tamaño:</b> <?php echo $resource->getSize(); ?> bytes.<br/>
    <b>Mime:</b>   <?php echo $resource->getFullMime(); ?><br/>
    Registrado el <?php echo $resource->getFormattedCreatedAt(); ?> | <?php echo link_to('Eliminar', '@resource_delete?slug='.$resource->getSlug(), 'confirm=Realmente quieres eliminar esta imagen?'); ?>
  </div>
</li>