<?php

/**
 * Patient form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PatientForm extends BasePatientForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'realname'         => 'Nombres y Apellidos',
      'username'         => 'Nombre de Usuario',
      'email'            => 'Correo Electr&oacute;nico',
      'url'              => 'Sitio Web',
      'twitter_username' => 'Twitter',
      'phone'            => 'Teléfono',
    );
  }
    
  public function configure()
  {
     $this->setWidgets(array(
        'id'               => new sfWidgetFormInputHidden(),
        'realname'         => new sfWidgetFormInputText(array(), array('size' => 40)),
        'username'         => new sfWidgetFormInputText(array(), array('size' => 40)),
        'email'            => new sfWidgetFormInputText(array(), array('size' => 40)),
        'url'              => new sfWidgetFormInputText(array(), array('size' => 40)),
        'twitter_username' => new sfWidgetFormInputText(array(), array('size' => 40)),
        'phone'            => new sfWidgetFormInputText(array(), array('size' => 20))
     ));
     
    $this->validatorSchema['confirm_password'] = new sfValidatorString(array('max_length' => 255));    
      	
    $this->types = array
    (
      'id'               => '=',
      'realname'         => 'name',
      'username'         => 'user',
      'password'         => '-',
      'confirm_password' => '-',
      'email'            => 'email',
      'url'              => 'url',
      'twitter_username' => 'text',
      'phone'            => 'phone',
      'active'           => '-',
      'last_access_at'   => '-',
      'slug'             => '-',
      'created_at'       => '-',
      'updated_at'       => '-'
    );
    

    
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array
    (
      new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('username'))),
      new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('email')))
    )));
  }
  
  protected function updateEmailColumn($email)
  {
    return Stringkit::strtolower($email);
  }
}
