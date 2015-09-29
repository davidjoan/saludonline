<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'realname'         => new sfWidgetFormInputText(),
      'username'         => new sfWidgetFormInputText(),
      'password'         => new sfWidgetFormInputText(),
      'email'            => new sfWidgetFormInputText(),
      'url'              => new sfWidgetFormInputText(),
      'twitter_username' => new sfWidgetFormInputText(),
      'phone'            => new sfWidgetFormInputText(),
      'active'           => new sfWidgetFormInputText(),
      'last_access_at'   => new sfWidgetFormDateTime(),
      'slug'             => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'realname'         => new sfValidatorString(array('max_length' => 200)),
      'username'         => new sfValidatorString(array('max_length' => 50)),
      'password'         => new sfValidatorString(array('max_length' => 255)),
      'email'            => new sfValidatorString(array('max_length' => 100)),
      'url'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_username' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'phone'            => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'active'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'last_access_at'   => new sfValidatorDateTime(array('required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('email'))),
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
