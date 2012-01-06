<?php use_helper('Date', 'Text') ?>
<div class="post-bottom-section">
    <?php if($post->getCantComments() > 0): ?>
    <h4><?php echo $post->getCantComments(); ?> comentarios</h4>
    <?php endif; ?>
    <div class="right">
        <ol class="commentlist">
          <?php foreach ($post->getComments() as $comment): ?>            
            <li class="depth-1">
                <div class="comment-info">
                    <img class="avatar" width="40" height="40" src="/images/frontend/gravatar.jpg" alt="">
                    <cite>
                      <?php echo link_to_if($comment->getAuthorUrl(), $comment->getAuthorName(), $comment->getAuthorUrl(), array('popup' => true)) ?>
                      Says:<br>
                      <span class="comment-data">
                      <a title="" href="#comment-63">Escrito hace <?php echo distance_of_time_in_words(strtotime($post->getDatetime()), strtotime($comment->getDatetime())) ?></a>
                      </span>
                    </cite>
                </div>
                <div class="comment-text">
                  <?php echo simple_format_text($comment->getContent()) ?>
                </div>
            </li>
          <?php endforeach ?>
        </ol>
    </div>
</div>

<div class="post-bottom-section">
  <h4>Deja un comentario</h4>
  <div class="right">
      
      
 <?php include_component('Generic', 'formulario', array
      (
        'form'          => $commentForm,
        'action_uri'    => url_for('@post_show?slug='.$post->getSlug()),
        'styles_folder' => 'log',
        'submit'        => 'Enviar Comentario',
        'with_title'    => false
      ))
  ?>
  </div>
</div>
