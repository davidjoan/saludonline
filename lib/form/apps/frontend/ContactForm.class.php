<?php

class ContactFrontendForm extends sfForm
{
  
  public function configure()
  {
     $this->setWidgets(array(
        'name'    => new sfWidgetFormInput(array(), array('size' => 40)),
        'email'   => new sfWidgetFormInput(array(), array('size' => 40)),
        'company' => new sfWidgetFormInput(array(), array('size' => 40)),
        'subject' => new sfWidgetFormInput(array(), array('size' => 40)),
        'message' => new sfWidgetFormTextarea(array(), array('cols' => 70, 'rows' => 5)),
        'captcha' => new sfWidgetFormInput(),
     ));
     
     $this->setValidators(array(
        'name'    => new sfValidatorString(array('required' => true)),
        'email'   => new sfValidatorEmail(),
        'subject' => new sfValidatorString(array('required' => false)),
        'company' => new sfValidatorString(array('required' => false)),
        'message' => new sfValidatorString(array('min_length' => 4)),
        'captcha' => new sfValidatorString(array('required' => false)),
    ));
     
    $this->widgetSchema->setNameFormat('contact[%s]'); 
  }
}