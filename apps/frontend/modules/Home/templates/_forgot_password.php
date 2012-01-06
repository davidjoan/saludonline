Hola <?php echo $patient->getRealname();  ?><br/>
<h4>Gracias por contactarte con Salud Online</h4><br/>

Esta son tus datos de acceso a Salud Online:<br/>

<b>usuario:</b>  <?php echo $patient->getUsername(); ?><br/>
<b>password:</b> <?php echo Cipher::getInstance()->decrypt($patient->getPassword()); ?><br/>

<p>&nbsp;</p>
Equipo Salud Online<br/>

