<?php

/**
 * LoginBackendValidator.
 *
 * @package    saludonline
 * @subpackage validator
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class LoginBackendValidator extends sfGlobalValidator
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('model');
    $this->addRequiredOption('column');
    $this->addRequiredOption('find_method');
    
    $this->setMessage('invalid'            , '"%column%" fields are incorrect.');
    $this->addMessage('wrong_password'     , 'The password you enter does not match.');
    $this->addMessage('inactive'           , 'Your account is inactive. Please contact with the system administrator.');
  }
  
  protected function doClean($values)
  {
    if ($this->hasEmptyValues($values))
    {
      return $values;
    }
    
    $columns     = (array) $this->getOption('column');
    $find_method = $this->getOption('find_method');
    $user        = Doctrine::getTable($this->getOption('model'))->$find_method($values[$columns[0]]);
    
    $arguments   = array();
    if (!$user)
    {
      $error     = 'invalid';
      $arguments = array('column' => implode(', ', $columns));
    }
    elseif (!kcCrypt::compare($user->getPassword(), $values[$columns[1]]))
    {
      $error     = 'wrong_password';
    }
    elseif (!$user->isActive())
    {
      $error     = 'inactive';
    }
    else
    {
      return $values;
    }
    
    throw new sfValidatorError($this, $error, $arguments);
  }
}
