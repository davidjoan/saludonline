<?php

/**
 * SessionObject provides advanced management 
 * of a certain object in session.
 * 
 * @package    symfext
 * @subpackage session
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
abstract class SessionObject
{
  protected
    $namespace = '',
    $id        = '',
    $object    = null;
    
  /**
   * Constructor
   * 
   * @param string  $namespace  The namespace to use
   * @param string  $id         The id of the object
   */
  public function __construct($namespace, $id)
  {
    $this->namespace = $namespace;
    $this->id        = $id;
  }
  
  /**
   * Initializes the instance.
   */
  public function initialize()
  {
    if (!$this->getUser()->getAttribute($this->id, null, $this->namespace))
    {
      $this->force();
    }
    
    $this->synchronize();
  }
  
  /**
   * Loads the target object in this instance.
   * 
   * @param mixed  $object  The object to load
   */
  abstract public function load($object);
  
  /**
   * Saves the current object to the database.
   *
   * @param mixed $con An optional connection object
   *
   * @return mixed The current saved object
   */
  public function save($con = null)
  {
    if (null === $con)
    {
      $con = $this->getConnection();
    }
    
    $this->doSave($con);
    $this->remove();
    
    return $this->object;
  }
  
  /**
   * Updates and saves the current object.
   *
   * @param mixed $con A connection object
   */
  abstract protected function doSave($con);
  
  
  /**
   * Removes and returns the object from session.
   *
   * @return mixed The removed object
   */
  public function remove()
  {
    return unserialize($this->getUser()->getAttributeHolder()->remove($this->id, null, $this->namespace));
  }
  /**
   * Synchronizes the current object and the one from session.
   */
  public function synchronize()
  {
    $this->object = unserialize($this->getUser()->getAttributeHolder()->get($this->id, null, $this->namespace));
  }
  /**
   * Updates the object from session with the current one.
   */
  public function force()
  {
    if (method_exists($this->object, 'serializeReferences'))
    {
      $this->object->serializeReferences(true);
    }
    
    $this->getUser()->getAttributeHolder()->set($this->id, serialize($this->object), $this->namespace);
  }
  /**
   * Returns the current object.
   * 
   * @return mixed The current object
   */
  public function getObject()
  {
    return $this->object;
  }
  /**
   * Sets the current object.
   * 
   * @param mixed The current object
   */
  protected function setObject($object)
  {
    $this->object = $object;
  }
  
  /**
   * Returns the connection associated with this instance (if any).
   *
   * @return Doctrine_Connection|null     the connection object
   */
  public function getConnection()
  {
    return Doctrine_Manager::getInstance()->getConnectionForComponent($this->getModelName());
  }
  /**
   * Returns the model associated with this instance.
   *
   * @return string The model name
   */
  public function getModelName()
  {
    return substr(get_class($this), 7);
  }
  
  /**
   * Returns the user object
   * 
   * @return sfUserExt The user object
   */
  public function getUser()
  {
    return sfContext::getInstance()->getUser();
  }
}
