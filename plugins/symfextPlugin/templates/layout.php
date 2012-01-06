<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php echo sfConfig::get('sf_images_path') ?>/general/favicon.ico" type="image/x-icon" />
    <?php use_stylesheet(sfConfig::get('sf_app').'/layout.css', 'first') ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  
  <body>
    <div class="wrap">
      <div class="header">
      </div>
      
      <div class="content">
        <?php echo $sf_content ?>
      </div>
      
      <div class="footer">
      </div>
    </div>
  </body>
</html>
