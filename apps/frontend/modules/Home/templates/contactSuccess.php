<div class="post">
  <div class="right">
<?php include_partial('General/alerts')?>      
<h3>Formulario de Contacto</h3>
<form id="contactform" class="form" action="<?php echo url_for('@contact')?>" method="post">

					<p class="no-border"><strong>Envianos un mensaje</strong></p>


					<p>
						<label for="name">Nombre</label><br>
						<?php echo $form['name']->render(); ?>
					</p>

					<p>
						<label for="email">E-mail</label><br>
						<?php echo $form['email']->render(); ?>
					</p>
                                        
					<p>
						<label for="email">Empresa</label><br>
						<?php echo $form['company']->render(); ?>
					</p>                                        
                                        
					<p>
						<label for="subject">Asunto</label><br>
						<?php echo $form['subject']->render(); ?>
					</p>                                           

					<p>
						<label for="message">Mensaje</label><br>
						<?php echo $form['message']->render(); ?>
					</p>

                                        <p>
						<label for="subject">Captcha</label><br>
						<?php echo $form['_csrf_token'] ?>
                                                <?php echo $form['captcha'] ?><br/>
                                                <?php echo image_tag(url_for('@image', true)) ?>           
					</p>     

					<p class="no-border">
						<input type="submit" tabindex="5" value="Enviar Mensaje" class="button">
					</p>

				</form>
  </div>
  <div class="left">
      <br/><br/><br/>
        <p class="no-border"><strong>Si tienes alguna duda, comentario o necesitas mas información no dudes en escribirnos.</strong></p>
  </div>    
</div>