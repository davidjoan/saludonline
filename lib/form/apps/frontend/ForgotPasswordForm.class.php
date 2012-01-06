<?php

class ForgotPasswordForm extends sfForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'email'            => 'Correo Electr&oacute;nico',
      'captcha'          => 'Captcha'
    );
  }
    
  public function configure()
  {
     $this->setWidgets(array(
        'email'            => new sfWidgetFormInputText(array(), array('size' => 40)),
        'captcha'          => new sfWidgetFormInputText(),
     ));
     
    $this->setValidators(array
    (
      'email'             => new sfValidatorString(array('required' => true, 'max_length' => 255)),
      'captcha'           => new sfValidatorString(array('required' => true)),
    ));
      	
    $this->types = array
    (
      'email'            => 'email',
      'captcha'          => '=',
    );
    
    $this->widgetSchema->setNameFormat('patient[%s]'); 
  }
}
