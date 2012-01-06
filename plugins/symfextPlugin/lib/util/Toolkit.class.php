<?php

/**
 * Toolkit
 *
 * @package    symfext
 * @subpackage lib
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Toolkit extends sfToolkit
{
  /**
   * Constructor.
   * 
   * Declared private to avoid instances of this class.
   */
  private function __construct() {}
  
  /**
   * Loads helpers.
   *
   * @param array  $helpers     An array of helpers to load
   * @param string $moduleName  A module name (optional)
   */
  public static function loadHelpers($helpers, $moduleName = '')
  {
    sfApplicationConfiguration::getActive()->loadHelpers($helpers, $moduleName);
  }
  
  /**
   * Creates a directory.
   *
   * @param  string $directory  A directory to create.
   *
   * @return boolean Whether or not the directory was successfully created or not
   * 
   * @throws sfException If there is a problem when creating the directory
   */
  public static function createDirectory($directory, $dir_mode = 0755)
  {
    if (!is_readable($directory))
    {
      if (!mkdir($directory, $dir_mode, true))
      {
        // failed to create the directory
        throw new sfException(sprintf('Failed to create directory "%s".', $directory));
      }

      // chmod the directory since it doesn't seem to work on recursive paths
      chmod($directory, $dir_mode);
    }

    if (!is_dir($directory))
    {
      // the directory path exists but it's not a directory
      throw new sfException(sprintf('File path "%s" exists, but is not a directory.', $directory));
    }

    if (!is_writable($directory))
    {
      // the directory isn't writable
      throw new sfException(sprintf('File path "%s" is not writable.', $directory));
    }
    
    return true;
  }
  /**
   * Deletes a directory.
   *
   * @param  string $directory  A directory to delete.
   *
   * @return boolean Whether or not the directory was successfully deleted or not
   * 
   * @throws sfException If there is a problem when deleting the directory
   */
  public static function deleteDirectory($directory)
  {
    if (!is_dir($directory))
    {
      return true;
    }
    
    self::clearDirectory($directory);
    
    if (!rmdir($directory))
    {
      // failed to delete the directory
      throw new sfException(sprintf('Failed to delete directory "%s".', $directory));
    }
    
    return true;
  }
  
  /**
   * Returns an unidimensional array from a multidimensional one.
   *
   * @param  array $array The array to flatten
   *
   * @return array The flattened array
   */
  public static function arrayFlatten($array, $flat = false)
  {
    if (!is_array($array) || empty($array))
    {
      return '';
    }
    
    if (empty($flat))
    {
      $flat = array();
    }
    
    foreach ($array as $key => $val)
    {
      if (is_array($val))
      {
        $flat = self::arrayFlatten($val, $flat);
      }
      elseif ($val)
      {
        $flat[] = $val;
      }
    }
    
    return $flat;
  }
  
  /**
   * Returns a string to be used as a parameter in a url.
   *
   * @param  array  $array The array to be converted
   *
   * @return string The url parameter
   */
  public static function convertArrayToUrlParameter($name, $elements)
  {
    $param = '';
    foreach ($elements as $element)
    {
      $param .= sprintf('%s[]=%s&', $name, $element);
    }
    
    return rtrim($param, '&');
  }
  
  /**
   * Returns the last entrance route from the stack of the module.
   *
   * @param  string  $module The module name
   *
   * @return string  The last entrance route
   */
  public static function getEntranceRoute($module)
  {
    $usClass   = sfInflector::underscore($module);
    $namespace = constant(sprintf('ActionsProject::%s_NAMESPACE', strtoupper($usClass))); 
    
    return sfContext::getInstance()->getUser()->getAttribute('current_route', sprintf('@%s_list', $usClass), $namespace);
  }
  
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
