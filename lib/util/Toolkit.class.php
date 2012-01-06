<?php

/**
 * Toolkit
 *
 * @package    flexiwik
 * @subpackage lib
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Toolkit extends sfToolkitExt
{
  /**
   * Clear the doctrine tables from the model.
   * 
   * Most commonly used in tests.
   */
  public static function clearTables()
  {
    foreach (Doctrine_Manager::getInstance()->getConnections() as $connection)
    {
      foreach ($connection->getTables() as $name => $table)
      {
        if ($name != 'PageIndex')
        {
          $table->clear();
        }
      }
    }
  }
  
  
  
  
  public static function getEntranceRouteFrontend($module)
  {
  	$usClass   = sfInflector::underscore($module);
  	$namespace = constant(sprintf('ActionsProject::%s_NAMESPACE', strtoupper($usClass)));
  
  	return sfContext::getInstance()->getUser()->getAttribute('current_route', sprintf('@%s_show', $usClass), $namespace);
  }  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  public static function encodeUrl($url)
  {
    return urlencode($url);
  }
  public static function decodeUrl($url)
  {
    return urldecode($url);
  }
  
  
  /**
   * Method used to avoid invalid characterss when creating a new page 
   * title and when creating a valid page url. (:)
   * 
   * A page title could be formed by:
   * 
   *  * The possible title
   *  * The category name
   *  * The section name
   * 
   * @param string $title The text to evaluate.
   * @return string The text with non-allowed characters replaced by white spaces.
   */
  public static function fixTitle($title)
  {
    $title = self::replaceForTitle($title);
    
    #$title = preg_replace("/[^a-zA-Z0-9\-_\(\)\[\]'çáäàâåæéêëèïíìîôöòóúûùüÿñ ÇÁÄÀÂÅÆÉÊËÈÍÌÎÔÖÒÚÛÙÜŸÑ]+/", ' ', $title);
    #$title = preg_replace("/[^a-zA-Z0-9\-_\(\)\[\]'çàáâãäåæèéêëìíîïòóôõöùúûüýÿñ ÇÀÁÂÃÄÅÆÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝŸÑ]+/", ' ', $title);
    $title = preg_replace("/[^a-zA-Z0-9\-_\(\)\[\]'çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñ ÇÀÁÂÃÄÅĀÆÈÉÊËĖĒĘÌÍÎÏĪĮÒÓÔÕŌÖØŒÙÚÛÜŮŨŪŲÝŸŶÑ]+/", ' ', $title);
    
    $title = trim($title, ' ');
    
    return $title;
  }
  public static function fixAndLowerTitle($title)
  {
    return self::fixTitle(self::strtolower($title));
  }
  public static function fixUrl($url)
  {
    $url = self::replaceForTitle($url);
    
    #$url = preg_replace("/[^a-z0-9\-_\(\)\[\]'çáäàâåæéêëèíìîôöòúûùüÿñ:]+/", '_', self::strtolower($url));
    #$url = preg_replace("/[^a-z0-9\-_\(\)\[\]'çàáâãäåæèéêëìíîïòóôõöùúûüýÿñ:]+/", '_', self::strtolower($url));
    $url = preg_replace("/[^a-z0-9\-_\(\)\[\]'çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñ:]+/", '_', self::strtolower($url));
    
    $url = trim($url, '_');
    
    return $url;
  }
  public static function fixUrlAccess($url)
  {
    $url = self::replaceForTitle($url);
    
    #$url = preg_replace("/[^a-z0-9\-_\\/(\)\[\]'çáäàâåæéêëèíìîôöòúûùüÿñ:]+/", '_', self::strtolower($url));
    #$url = preg_replace("/[^a-z0-9\-_\\/(\)\[\]'çàáâãäåæèéêëìíîïòóôõöùúûüýÿñ:]+/", '_', self::strtolower($url));
    $url = preg_replace("/[^a-z0-9\-_\\/(\)\[\]'çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñ:]+/", '_', self::strtolower($url));
    
    $url = trim($url, '_');
    
    return $url;
  }
  
  public static function sanitizeContent($string)
  {
    $sanitizer = new kcSanitizer($string);
    $string    = $sanitizer->sanitize();
    return mb_strtolower($string, $sanitizer->getEncoding());
  }
  
  
  public static function cleanFileName($filename)
  {
    return self::getUrlFromTitle(strtolower(substr($filename, 0, strrpos($filename, '.'))));
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  public static function renderContentTag($content, $html_tag = 'em')
  {
    return sprintf('<%s>%s</%s>', $html_tag, $content, $html_tag);
  }
  
  public static function getConnection($name = null)
  {
    $conn = $name 
              ? sfContext::getInstance()->getDatabaseManager()->getDatabase($name)->getDoctrineConnection() 
              : Doctrine_Manager::getInstance()->getCurrentConnection();
              
    return $conn;
  }
  
  
  
  
  
  public static function substr($string, $length = 15, $suffix = '...')
  {
    return strlen($string) > $length ? substr($string, 0, $length - 3).$suffix : $string; 
  }
  
  /**
   * Changes every end of line from CR or LF to CRLF.  Returns string.
   * @access private
   * @return string
   */
  public static function doFixEOL($string)
  {
    $string = str_replace("\r\n", "\n", $string);
    $string = str_replace("\r", "\n", $string);
    $string = str_replace("\n", '<br>', $string);
    return $string;
  }
  
  /**
   * Changes every CRLF to CR or LF.  Returns string.
   * @access private
   * @return string
   */
  public static function doUnfixEOL($string)
  {
    $string = str_replace("<br>", "\r\n", $string);
    return $string;
  }
  
  public static function getUrlFromTitle($title)
  {
    //$search  = array('Á','É','Í','Ó','Ú','Ñ','á','é','í','ó','ú','ñ');
    //$replace = array('A','E','I','O','U','N','a','e','i','o','u','n');
    
    //$name_url = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower(str_replace($search, $replace, $name)));
    $url = preg_replace('/[^a-zA-Z0-9_\:\!]/', '_', $title);
    
    return $url;
  }
  
  
  public static function encodeText($text)
  {
    return htmlspecialchars($text);
  }
}
