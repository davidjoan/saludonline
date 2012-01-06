<?php

/**
 * Filekit
 *
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Filekit
{
  /**
   * Constructor.
   * 
   * Declared private to avoid instances of this class.
   */
  private function __construct() {}
  
  /**
   * Returns an extension converted to .jpg if not .gif or .png:
   *
   * @param  string  $extension  The extension to convert
   *
   * @return string  The converted extension
   */
  public static function convertExtension($extension)
  {
    return in_array($extension, array('.gif', '.jpg', '.png')) ? $extension : '.jpg';
  }
  /**
   * Returns a path compose by the hash of the name.
   *
   * @param  string  $name      The name to make the path
   * @param  integer $levels    The levels of the path
   * @param  boolean $generate  If the name should be hashed first (true by default)
   *
   * @return string  The composed path
   */
  public static function getHashPathForLevel($name, $levels, $generate = true)
  {
    if (0 == $levels)
    {
      return '';
    }
    
    $levels++;
    $hash = $generate ? md5($name) : $name;
    $path = '/';
    for ($i = 1; $i < $levels; $i++)
    {
      $path .= substr($hash, 0, $i).'/';
    }
    
    return rtrim($path, '/');
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
}
