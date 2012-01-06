<?php use_helper('Text') ?>
<?php include_partial('General/alerts')?>

<?php foreach ($posts as $post): ?>
<div class="post">
  <div class="right">
      
    <h2><?php echo link_to($post->getTitle(), '@post_show?slug='.$post->getSlug()) ?></h2>
    <?php if($post->getImage() <> ''):?>
    <div class="image-section">
      <?php echo image_tag(PostTable::getInstance()->getImagePath().'/'.$post->getImage(), array('size' => '500x200'));?>
    </div>
    <?php endif; ?>

    <p>
    <?php echo simple_format_text($post->getExcerpt()); ?>
    </p>
  </div>

  <div class="left">
    <p class="dateinfo"><?php echo date("M",strtotime($post->getCreatedAt())); ?><span><?php echo date("d",strtotime($post->getCreatedAt())); ?></span></p>
    <div class="post-meta">
        <h4>Post Info</h4>
        <ul>
          <li class="user"><a href="#"><?php echo $post->getUserRealname(); ?></a></li>
          <li class="time"><a href="#"><?php echo date("H:m:i A",strtotime($post->getCreatedAt())); ?></a></li>
          <li class="comment"><a href="#"><?php echo $post->getCantComments(); ?> Comentarios</a></li>
        </ul>
    </div>
    <div class="post-meta">
      <h4>Categorias</h4>
      <ul class="tags">
        <?php foreach($post->getCategories() as $categoria):?>
        <li><a href="/" rel="tag"><?php echo $categoria->getName(); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>        
  </div>
</div>
<?php endforeach; ?>