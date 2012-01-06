<?php use_helper('Date', 'Text') ?>

<?php if(!$sf_user->isAuthenticated()):?> 
<script lang="javascript">
$(document).ready(function()
{$("#login_form").submit(function()
  {$("#msgbox").removeClass().addClass('messagebox').text('Validando....').fadeIn(1000);$.post("/login",{ user_name:$('#login_frontend_username').val(),password:$('#login_frontend_password').val(),rand:Math.random() } ,function(data)
  {if(data=='si')
  {$("#msgbox").fadeTo(200,0.1,function()
    {$(this).html('Iniciando sesión').addClass('messageboxok').fadeTo(900,1,function()
      {document.location='/panel';
      });});}
   else 
   {if(data=='mal')
     {$("#msgbox").fadeTo(200,0.1,function()
       {$(this).html('Intentalo despues').addClass('messageboxerror').fadeTo(900,1);});         
     }else{$("#msgbox").fadeTo(200,0.1,function()
       {$(this).html('Login incorrecto').addClass('messageboxerror').fadeTo(900,1);});}}});
       return false;});
    $("#login_frontend_password").blur(function()
    {$("#login_form").trigger('submit');});});
</script>

<div id="social-register" class="registration_panel">
<a id="facebook-login" class="fb_button fb_button_medium" href="/login/facebook">
<span class="fb_button_text">Login with Facebook</span>
</a>
</div>
<h3>ó Login</h3>
  <form action="" method="post" id="login_form" class="login">
  <p>
    <label for="name">Usuario</label><br />
    <?php echo $form['username']->render(); ?>
  </p>
  <p>
    <label for="email">Contraseña</label><br />
    <?php echo $form['password']->render(); ?>
  </p>
  <p class="no-border">
    <input class="button" id="submit" type="submit" value="Login" tabindex="5" /><span id="msgbox" style="display:none"></span>
    <br/>
    <?php echo link_to('Olvido su Contraseña?', '@forgot_password'); ?>
  </p>
  </form>
<?php else: ?>
<script>
    $(function(){
        $("#progressbar").progressbar({
            value: <?php echo $sf_user->getProgress(); ?>});
    });
</script>
Tu cuenta esta al <?php echo $sf_user->getProgress(); ?>%
<div id="progressbar"></div>
<?php endif; ?>

  <div class="about-me">
    <h3>Sobre el Proyecto</h3>
    <p>
      <?php echo image_tag(CompanyTable::getInstance()->getImagePath().'/'.$company->getImage(), array('size' => '40x40', 'alt' => 'Salud Online', 'class' => 'float-left' ));?>
      <?php echo $company->getDescription(); ?>
    </p>
  </div>

  <div class="fb-like-box" data-href="http://www.facebook.com/saludonline" data-width="240" data-show-faces="true" data-stream="true" data-header="true"></div>

  
  <?php if(!$sf_user->isAuthenticated()):?> 
  <div class="sidemenu">
    <h3>Menu</h3>
      <ul>
        <?php foreach($actions as $action): ?>
        <li>
          <?php echo link_to($action['name'], $action['url']); ?>
        </li>
        <?php endforeach; ?>	     
      </ul>
  </div>
<?php endif; ?>

  <div class="sidemenu">
    <h3>Auspiciadores</h3>
    <ul>
      <?php foreach($sponsors as $sponsor): ?>
	<li><a href="<?php echo $sponsor->getUrl(); ?>" title="<?php echo $sponsor->getName(); ?>" target="BLANK"><?php echo $sponsor->getName(); ?> <br />
	  <span><?php echo $sponsor->getDescription(); ?></span></a>
	</li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="popular">
    <h3>Más populares</h3>
      <ul>
        <?php foreach($posts as $post): ?>
	  <li><?php echo link_to($post->getTitle(), '@post_show?slug='.$post->getSlug()) ?>
          <br /><span>Escrito hace <?php echo distance_of_time_in_words(strtotime($post->getDatetime()), time()) ?></span>
	  </li>
        <?php endforeach; ?>
      </ul>
  </div>
<!-- /sidebar -->