<div class="post">
  <div class="right">
<?php include_partial('General/alerts')?>      
<h3>Registrate Ahora!</h3>
<form id="registerform" class="form" action="<?php echo url_for('register')?>" method="post">
  <p class="no-border"><strong></strong></p>
  <p>
    <label for="realname">Nombres y Apellidos</label><br>
    <?php echo $form['realname']->render(); ?>
  </p>
  <p>
    <label for="username">Nombre de Usuario</label><br>
    <?php echo $form['username']->render(); ?>
  </p>
  <p>
    <label for="password">Contraseña</label><br>
    <?php echo $form['password']->render(); ?>
  </p>
  <p>
    <label for="confirm_password">Confirmar Contraseña</label><br>
    <?php echo $form['confirm_password']->render(); ?>
  </p>
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
    <input type="submit" tabindex="5" value="Registrar" class="button">
  </p>
  </form>
  </div>
  <div class="left">
      <br/>
        <p class="no-border"><strong>Registrate sin costo alguno y podras utilizar todos nuestros servicios.</strong></p>
  </div>
</div>