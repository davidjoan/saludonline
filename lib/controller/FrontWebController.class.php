<?php

class FrontWebController extends sfFrontWebController
{
  /*public function genUrl($parameters = array(), $absolute = false)
  {
    $url = parent::genUrl($parameters, $absolute);
    
    if (strpos($url, '/web/') !== false && (preg_match('/\.php/', $url) || preg_match('/index\.php/', $_SERVER['SCRIPT_NAME'])))
    {
      $url = substr($url, 0, strpos($url, 'web')).substr($url, strpos($url, 'web') + 4);
    }

    return $url;
  } */
}
