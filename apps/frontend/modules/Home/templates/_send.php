
<h3>Usted ha recibido un nuevo mensaje de <?php echo $sf_request->getUri() ?></h3>

<p>
  Nombre:<strong> <?php echo $form->getValue('name') ?></strong><br />
  Email:<strong> <?php echo $form->getValue('email') ?></strong><br />
  Empresa:<strong> <?php echo $form->getValue('company') ?></strong><br />
  Asunto:<strong> <?php echo $form->getValue('subject') ?></strong><br />
  Mensaje:<strong> <?php echo nl2br($form->getValue('message')) ?></strong><br />

</p>
<p>&nbsp;</p>
Salud Online<br/>

