<?php

/**
 * sfStringkitExt
 *
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfStringkitExt
{
  protected static
    $encoding    = 'UTF-8',
    $reUrl       = "/[^a-z0-9\-_\(\)\[\]'çàáâãäåāæèéêëėēęìíîïīįòóôõōöøœùúûüůũūųýÿŷñ:]+/";
    
  /**
   * Constructor
   * 
   * @throws sfExceptionExt
   */
  public function __construct()
  {
    throw new sfExceptionExt('sfStringkitExt is a static class. No instances can be created.');
  }
  
  /**
   * Returns an array with each of the characters of the string.
   *
   * It has multibyte support.
   *
   * @param  string $string The string to split
   *
   * @return array The array with the characters
   */
  public static function str_split($string)
  {
    $container = array();
    $length    = mb_strlen($string);
    
    for ($i = 0; $i < $length; $i++)
    {
      $container[] = mb_substr($string, $i, 1, self::$encoding);
    }
    
    return $container;
  }
  /**
   * Returns a lower case string using the multibyte function.
   *
   * @param  string $filename The string to lower
   *
   * @return string The lower string
   */
  public static function strtolower($string)
  {
    return mb_strtolower($string, self::$encoding);
  }
  
  /**
   * Returns a string with the "’" and "‘" replaced by "'".
   *
   * @param  string $filename The string to evaluate
   *
   * @return string The fixed string
   */
  public static function fixQuotes($string)
  {
    $search  = array("’", "‘", "“", "”", "´", "…"  );
    $replace = array("'", "'", '"', '"', "'", "...");
    
    return str_replace($search, $replace, $string);
  }
  
  /**
   * Fix a filename to be used in the name of a real file.
   *
   * @param  string $filename The proposed filename
   *
   * @return string The fixed filename
   */
  public static function fixFilename($filename)
  {
    $filename = preg_replace("/[^a-zA-Z0-9_]+/", '_', self::strtolower($filename));
    
    return trim($filename, '_');
  }
  
  /**
   * Fix a string to be used as url.
   *
   * @param  string $url The original string
   *
   * @return string The fixed url
   */
  public static function fixUrl($url)
  {
    $url = self::fixQuotes($url);
    
    $url = preg_replace(self::$reUrl, '_', self::strtolower($url));
    
    return trim($url, '_');
  }
  
  /**
   * Fix a filter string.
   *
   * @param  string $filter The original filter
   *
   * @return string The fixed filter
   */
  public static function fixFilter($filter)
  {
    return str_replace('|', ' ', $filter);
  }
  /**
   * Unfix a filter string.
   *
   * @param  string $filter The fixed filter
   *
   * @return string The unfixed filter
   */
  public static function unfixFilter($filter)
  {
    return str_replace(' ', '|', $filter);
  }
}
