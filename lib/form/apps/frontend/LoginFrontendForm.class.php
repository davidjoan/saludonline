<?php

/**
 * LoginFrontendForm.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class LoginFrontendForm extends BaseForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'username'             => 'Usuario',
      'password'             => 'Password',
    );
    
    $this->setOption('required_labels', false);
  }
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'username'             => new sfWidgetFormInputText(array(), array('size' => 25)),
      'password'             => new sfWidgetFormInputPassword(array(), array('size' => 25)),
    ));
    
    $this->setValidators(array
    (
      'username'             => new sfValidatorString(array('max_length' => 255)),
      'password'             => new sfValidatorString(array('max_length' => 255)),
    ));
    
    $this->types = array
    (
      'username'             => 'text',
      'password'             => 'password',
    );
    
    $this->validatorSchema->setPostValidator(new LoginValidator(array
    (
      'model'       => 'Patient',
      'column'      => array('username', 'password'),
      'find_method' => 'findOneByLowerCaseUsername',
    )));
  }
}
