<?php

/**
 * SessionRepository holds the information
 * about the session objects.
 * 
 * @package    symfext
 * @subpackage session
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class SessionRepository
{
  protected static
    $sessionObjects = array();
    
  /**
   * Constructor
   * 
   * @throws sfExceptionExt
   */
  public function __construct()
  {
    throw new sfExceptionExt('Session repository is a static class. No instances can be created.');
  }
  
  /**
   * Returns the object based on the parameters.
   * 
   * @param string  $model      The model of the session object
   * @param string  $namespace  The namespace of the session object
   * @param string  $id         The id of the session object
   * 
   * @return SessionObject|mixed The session object 
   */
  public static function getObject($model, $namespace = null, $id = null)
  {
    if (null === $namespace)
    {
      $namespace = constant(sprintf('ActionsProject::%s_NAMESPACE', strtoupper($model)));
    }
    if (null === $id)
    {
      $id = $model;
    }
    
    if (isset(self::$sessionObjects[$model][$namespace][$id]))
    {
      return self::$sessionObjects[$model][$namespace][$id];
    }
    
    $class = 'Session'.$model;
    self::$sessionObjects[$model][$namespace][$id] = new $class($namespace, $id);
    
    return self::$sessionObjects[$model][$namespace][$id];
  }
}
