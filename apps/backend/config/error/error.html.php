<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = sfConfig::get('sf_relative_url_root', preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : ''))) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="Artble Admin" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="artble admin" />
    <meta name="keywords" content="artble, admin" />
    <meta name="language" content="en" />
    <title>Artble Admin</title>
    
    <link rel="shortcut icon" href="<?php echo $path ?>/images/general/favicon.ico" type="image/x-icon" />
    
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/general/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/backend/general.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/backend/button.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/backend/default/layout.css" />
  </head>
  
  <body>
    <div class="wrap">
      <div class="header">
        <br/><br/>
        Salud Online
      </div>
      
      <div class="content">
        <h1>An Error Occurred</h1>
        <h5>We are having some troubles. Please try again in a few seconds...</h5>
        
        <br/><br/>
        <br/><br/>
        
        <a href="#" onclick="history.back(); return false;">Back to previous page</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/home">Go to Homepage</a>
      </div>
      
      <div class="footer">
        © 2011 Salud Online. All Rights Reserved.
      </div>
    </div>
  </body>
</html>
