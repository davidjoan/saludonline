<?php

/**
 * LoginBackendForm.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class LoginBackendForm extends BaseForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'email'                => 'E-mail Address',
      'password'             => 'Password',
    );
    
    $this->setOption('required_labels', false);
  }
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'email'                => new sfWidgetFormInputText(array(), array('size' => 50)),
      'password'             => new sfWidgetFormInputPassword(array(), array('size' => 50)),
    ));
    
    $this->setValidators(array
    (
      'email'                => new sfValidatorString(array('max_length' => 255)),
      'password'             => new sfValidatorString(array('max_length' => 255)),
    ));
    
    $this->types = array
    (
      'email'                => 'email',
      'password'             => 'password',
    );
    
    $this->validatorSchema->setPostValidator(new LoginValidator(array
    (
      'model'       => 'User',
      'column'      => array('email', 'password'),
      'find_method' => 'findOneByLowerCaseEmail',
    )));
  }
}
