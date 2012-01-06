<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('backend/log/layout.css', 'first') ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  
  <body>
    <div class="wrap">
      <div class="header">
          <?php echo image_tag('general/logo.jpg', array('size' => '150x150'))?>
      </div>
      
      <div class="content">
        <?php echo $sf_content ?>
      </div>
      
      <div class="footer">
        © 2010 <?php echo link_to('Data Solutions', 'http://datasolutions.pe') ?> - <?php echo link_to('Salud Online', '/') ?>
      </div>
    </div>
  </body>
</html>
