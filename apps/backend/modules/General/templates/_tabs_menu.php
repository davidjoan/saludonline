<table class="menu">
  <tr>
    <td width="99%">
      <table class="submenu">
        <tr>
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Home', 
                  'uri'         => '@home',
                  'image'       => 'backend/menu/home.gif',
                ))
          ?>
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Posts', 
                  'uri'         => '@post_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))
          ?>
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Sponsor', 
                  'uri'         => '@sponsor_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))
          ?>     
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Category', 
                  'uri'         => '@category_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))
          ?>		  
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Company', 
                  'uri'         => '@company_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))
          ?>	            
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Usuarios', 
                  'uri'         => '@patient_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))
          ?>            
          <?php /*include_partial('General/tab', array
                (
                  'title'       => 'Tratamientos', 
                  'uri'         => '@treatment_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))*/
          ?>      
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Especialidades', 
                  'uri'         => '@specialty_list',
                  'image'       => 'backend/menu/inventory.gif',
                ))
          ?>            
        </tr>
      </table>
    </td>
    <td width="1%">
      <table class="submenu">
        <tr>
          <?php include_partial('General/tab', array
                (
                  'title'       => 'Sign Out', 
                  'uri'         => '@log_logout',
                  'image'       => 'backend/menu/logout.gif',
                ))
          ?>
      </table>
    </td>
  </tr>
</table>
