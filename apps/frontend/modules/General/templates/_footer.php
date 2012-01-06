<?php if(!$sf_user->isAuthenticated()):?> 
<div id="footer-outer" class="clear"><div id="footer-wrap">
  <div class="col-a">
    <h3>Información de contacto</h3>
    <p>
      <strong>Teléfono:</strong><?php echo $company->getPhones(); ?><br/>
      <strong>Fax: </strong><?php echo $company->getFax(); ?>
    </p>
    <p><strong>Dirección: </strong><?php echo $company->getAddress(); ?></p>
    <p><strong>E-mail: </strong><?php echo $company->getMail(); ?></p>
    <p>Quieres más información - puedes ir a nuestra <?php echo link_to('formulario de contacto','@contact'); ?></p>
  </div>
        
  <div class="col-a">
    <h3>Actualizaciones</h3>
    <ul class="subscribe-stuff">
      <li>
        <?php echo link_to(image_tag('frontend/social_rss.png', array('title' => 'RSS')), '@feed_last_posts', array('title' => 'RSS', 'rel' => 'nofollow')); ?>
      </li>
      <li>
        <?php echo link_to(image_tag('frontend/social_facebook.png', array('title' => 'Facebook')), 'http://www.facebook.com/saludonline', array('title' => 'Facebook', 'rel' => 'nofollow','target'=>'BLANK')); ?>
      </li>
      <li>
        <?php echo link_to(image_tag('frontend/social_twitter.png', array('title' => 'Twitter')), 'https://twitter.com/#!/saludonlineperu', array('title' => 'Twitter', 'rel' => 'nofollow','target'=>'BLANK')); ?>
      </li>
      <li><a title="E-mail this story to a friend!" href="mailto:contact@datasolutions.pe" rel="nofollow">
	<?php echo image_tag('frontend/social_email.png', array('title' => 'Email')); ?></a>
      </li>
    </ul>
    <p>Mantente al día. Suscribirse vía <?php echo link_to('RSS', '@feed_last_posts');?>, <?php echo link_to('Facebook', '/');?>, <?php echo link_to('Twitter', '/');?> ó <a href="mailto:contact@datasolutions.pe">Email</a></p>
  </div>
  <div class="col-a">
    <h3>Site Links</h3>
      <div class="footer-list">
        <ul>
	<?php foreach($actions as $action): ?>
          <li>
            <?php echo link_to(truncate_text($action['name'],30,'...'), $action['url'], array('title' => $action['name'] )); ?>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
  </div>

  <div class="col-b">
    <h3>Comentarios Recientes</h3>
    <div class="recent-comments">
    <ul>
      <?php foreach($comments as $comment): ?>
        <li><a href="#" title="<?php echo $comment->getContent(); ?>"><?php echo truncate_text($comment->getContent(), 126, $truncate_string = '...', $truncate_lastspace = true); ?><?php //echo $comment->getContent();?></a><br /> &#45; <cite><?php echo $comment->getAuthorName(); ?></cite></li>
        
      <?php endforeach; ?>
    </ul>
    </div>
  </div>
</div></div>
<?php endif; ?>

<div id="footer-bottom">
  <p class="bottom-left">
    &copy; 2011 <strong>Salud Online</strong>&nbsp; &nbsp; &nbsp;
    Desarrollado por <a href="http://datasolutions.pe/">Data Solutions</a>
  </p>
  <p class="bottom-right">
    <!--<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> |
    <a href="http://validator.w3.org/check/referer">XHTML</a>	|-->
    <?php echo link_to('Inicio','@homepage'); ?> |
    <?php echo link_to('Contactenos','@contact'); ?> |
    <?php echo link_to('Registrate','@register'); ?> |
    <?php echo link_to('RSS Feed','@feed_last_posts'); ?> |
    <strong><a href="#top">Back to Top</a></strong>
  </p>
</div>