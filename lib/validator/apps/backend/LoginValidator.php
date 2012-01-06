<?php

/**
 * LoginValidator
 *
 * @package    withmory
 * @subpackage validator
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class LoginValidator extends sfGlobalValidator
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('model');
    $this->addRequiredOption('column');
    $this->addRequiredOption('find_method');
    
    $this->setMessage('invalid'            , '"%col%" campos incorrectos.');
    $this->addMessage('wrong_password'     , 'El password ingresado no es el correcto.');
    $this->addMessage('inactive'           , 'Tu cuenta está desactivada. Por favor comunícate con el administrador.');
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
      $arguments = array('col' => implode(', ', $columns));
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
