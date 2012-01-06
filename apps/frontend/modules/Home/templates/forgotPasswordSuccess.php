<div class="post">
  <div class="right">
<?php include_partial('General/alerts')?>      
<h3>Recupera tu contraseña en un instante.</h3>
<form id="forgotPasswordform" class="form" action="<?php echo url_for('forgot_password')?>" method="post">
  <p class="no-border"><strong></strong></p>
  <p>
    <label for="email">Correo Electr&oacute;nico</label><br>
    <?php echo $form['email']->render(); ?>
  </p>
  <p>
    <label for="subject">Captcha</label><br>
    <?php echo $form['_csrf_token'] ?>
    <?php echo $form['captcha'] ?><br/>
    <?php echo image_tag(url_for('@image', true)) ?>
  </p>
  <p class="no-border">
    <input type="submit" tabindex="5" value="Recuperar Contraseña" class="button">
  </p>
  </form>
  </div>
  <div class="left">
      <br/>
        <p class="no-border"><strong>Si olvidaste tu contraseña, solo escribe tu email y dentro de poco recibiras un email con tu contraseña!</strong></p>
  </div>
</div>