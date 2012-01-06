<div id="header-wrap">
  <div id="header">
    <?php if(!$sf_user->isAuthenticated()):?> 
    <h1 id="logo-text"><?php echo link_to('Salud Online<sub> beta</sub>','@homepage', array('title' => 'SaludOnline')); ?></h1>
    <p id="slogan">Salud y Tecnología a tu alcance... </p>        
    <div  id="nav">
      <ul>
        <?php include_partial('General/menu_item', array('title' => 'Inicio'      , 'uri' => '@homepage')) ?>
        <?php include_partial('General/menu_item', array('title' => 'Registrate'  , 'uri' => '@register')) ?>
        <?php include_partial('General/menu_item', array('title' => 'Contactenos' , 'uri' => '@contact')) ?>
      </ul>
    </div>
    <p id="rss">
      <?php echo link_to('Suscribirse Ahora', '@feed_last_posts', array('target' => 'BLANK')); ?>
    </p>
    <?php else: ?>
    <h1 id="logo-text"><?php echo link_to('Salud Online<sub> beta</sub>','@profile_show', array('title' => 'SaludOnline')); ?></h1>
    <p id="slogan">Salud y Tecnología a tu alcance... </p>    
    <div  id="nav">
      <ul>
        <?php include_partial('General/menu_item', array('title'   => 'Mis Perfiles'         , 'uri' => '@profile_show')) ?>
        <?php include_partial('General/menu_item', array('title'   => 'Mis Doctores'         , 'uri' => '@doctor_show')) ?>
        <?php include_partial('General/menu_item', array('title'   => 'Mis Imagenes'         , 'uri' => '@resource_show')) ?>
        <?php include_partial('General/menu_item', array('title'   => 'Contacto Emergencias' , 'uri' => '@contact_show')) ?>
          
      </ul>
    </div>
    <p id="logout">
       <?php echo link_to('Cerrar Sesión', '@log_logout'); ?>
    </p>
    <p id="welcome" class="user">Bienvenido <?php echo link_to($sf_user->getRealname(), '@patient_edit');  ?></p>
    <?php endif; ?> 
  </div>
</div>