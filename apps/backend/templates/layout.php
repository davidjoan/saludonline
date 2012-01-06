<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/images/general/favicon.ico" type="image/x-icon" />
    <?php use_stylesheet(sfConfig::get('sf_app').'/layout.css', 'first') ?>
    <?php use_stylesheet('backend/menu.css'  , 'first') ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
  </head>
  
  <body>
    <div class="wrap">
      <div class="header">
        <?php include_partial('General/header') ?>
      </div>
      
      <div class="content">
        <table class="main">
          <tr>
            <td class="left">
              <?php include_component('General', 'leftBox') ?>
            </td>
            <td class="right">
              <?php include_partial('General/tabs_menu') ?>
              
              <div class="text">
                <?php echo $sf_content ?>
              </div>
            </td>
          </tr>
        </table>
      </div>
      
      <div class="footer">
        <?php include_partial('General/footer') ?>
      </div>
    </div>
  </body>
</html>
