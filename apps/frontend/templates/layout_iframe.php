<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <style>
        body {
	font: 12px/170% 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, Sans-Serif;
	color: #777;
	margin: 0; padding: 0;
        background: white;
}
    </style>
  </head>
  <body>
    <div id="content-iframe">
      <div>
        <div id="main-iframe">
          <?php echo $sf_content ?>
        </div>               
      </div>
    </div>
  </body>
</html>
