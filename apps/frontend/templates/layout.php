<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <meta name="google-site-verification" content="i2vBoO2QcRi0T5lEwO_hhtdZxCFTFZz2xcp520dTo8w" />
    <script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
      <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-26669408-1']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
  </head>
  <body>
    <?php include_partial('General/header')?>
    <div id="content-wrap" class="clear">
      <div id="content">
        <div id="main">
          <?php echo $sf_content ?>
        </div>
        <div id="sidebar">
          <?php include_component('General','sidebar')?>
        </div>        
      </div>
    </div>
      <?php include_component('General','footer')?>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({appId: '216460831062', status: true, cookie: true, xfbml: true});
    };
    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol +
                '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
    </script>
  </body>
</html>