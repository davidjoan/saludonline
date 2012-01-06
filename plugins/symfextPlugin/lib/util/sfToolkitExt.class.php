<?php

/**
 * sfToolkitExt
 *
 * @package    symfext
 * @subpackage lib
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfToolkitExt extends sfToolkit
{
  /**
   * Constructor
   * 
   * @throws sfExceptionExt
   */
  public function __construct()
  {
    throw new sfExceptionExt('sfToolkitExt is a static class. No instances can be created.');
  }
  
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
   * Clear the doctrine tables from the model for all connections.
   * 
   * Most commonly used in tests.
   */
  public static function clearTables()
  {
    foreach (Doctrine_Manager::getInstance()->getConnections() as $connection)
    {
      $connection->clear();
    }
  }
}
