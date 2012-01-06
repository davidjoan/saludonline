<?php

class RegisterForm extends BasePatientForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'realname'         => 'Nombres y Apellidos',
      'username'         => 'Nombre de Usuario',
      'password'         => 'Contraseña',
      'confirm_password' => 'Confirmar Contraseña',
      'email'            => 'Correo Electr&oacute;nico',
      'captcha'          => 'Captcha'
    );
  }
    
  public function configure()
  {
     $this->setWidgets(array(
        'id'               => new sfWidgetFormInputHidden(),
        'realname'         => new sfWidgetFormInputText(array(), array('size' => 40)),
        'username'         => new sfWidgetFormInputText(array(), array('size' => 40)),
        'password'         => new sfWidgetFormInputPassword(array(), array('size' => 40)),
        'confirm_password' => new sfWidgetFormInputPassword(array(), array('size' => 40)),
        'email'            => new sfWidgetFormInputText(array(), array('size' => 40)),
        'captcha'          => new sfWidgetFormInputText(),
     ));
     
    $this->validatorSchema['confirm_password'] = new sfValidatorString(array('max_length' => 255));    
    $this->validatorSchema['captcha'] = new sfValidatorString(array('required' => false));    
      	
    $this->types = array
    (
      'id'               => '=',
      'realname'         => 'name',
      'username'         => 'user',
      'password'         => 'password',
      'confirm_password' => 'password',
      'email'            => 'email',
      'url'              => '-',
      'twitter_username' => '-',
      'phone'            => '-',
      'active'           => '-',
      'last_access_at'   => '-',
      'slug'             => '-',
      'created_at'       => '-',
      'updated_at'       => '-',
      'captcha'          => '=',
    );
    

    
    if (!$this->isNew())
    {
      $this->validatorSchema['password']->setOption('required', false);
      $this->validatorSchema['confirm_password']->setOption('required', false);
    }
    
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array
    (
      new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('username'))),
      new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('email'))),
      new sfValidatorSchemaCompare
      (
        'password', sfValidatorSchemaCompare::EQUAL, 'confirm_password',
        array('throw_global_error' => true),
        array('invalid'            => 'Los campos \'%password%\' y \'%confirm_password%\' deben ser iguales.')
      )
    )));
    
    $this->widgetSchema->setNameFormat('register[%s]'); 
  }
  
  protected function updatePasswordColumn($password)
  {
    return empty($password) ? false : $password;
  }
  
  protected function updateEmailColumn($email)
  {
    return Stringkit::strtolower($email);
  }
}
