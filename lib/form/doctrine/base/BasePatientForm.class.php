<?php

/**
 * Patient form base class.
 *
 * @method Patient getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePatientForm extends BaseFormDoctrine
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
      'facebook_id'      => new sfWidgetFormInputText(),
      'slug'             => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'profiles_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profile')),
      'doctors_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Doctor')),
      'contacts_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Contact')),
      'resources_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Resource')),
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
      'facebook_id'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'profiles_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profile', 'required' => false)),
      'doctors_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Doctor', 'required' => false)),
      'contacts_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Contact', 'required' => false)),
      'resources_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Resource', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('email'))),
        new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('facebook_id'))),
        new sfValidatorDoctrineUnique(array('model' => 'Patient', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('patient[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Patient';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['profiles_list']))
    {
      $this->setDefault('profiles_list', $this->object->Profiles->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['doctors_list']))
    {
      $this->setDefault('doctors_list', $this->object->Doctors->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['contacts_list']))
    {
      $this->setDefault('contacts_list', $this->object->Contacts->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['resources_list']))
    {
      $this->setDefault('resources_list', $this->object->Resources->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProfilesList($con);
    $this->saveDoctorsList($con);
    $this->saveContactsList($con);
    $this->saveResourcesList($con);

    parent::doSave($con);
  }

  public function saveProfilesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['profiles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Profiles->getPrimaryKeys();
    $values = $this->getValue('profiles_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Profiles', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Profiles', array_values($link));
    }
  }

  public function saveDoctorsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['doctors_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Doctors->getPrimaryKeys();
    $values = $this->getValue('doctors_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Doctors', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Doctors', array_values($link));
    }
  }

  public function saveContactsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['contacts_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Contacts->getPrimaryKeys();
    $values = $this->getValue('contacts_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Contacts', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Contacts', array_values($link));
    }
  }

  public function saveResourcesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['resources_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Resources->getPrimaryKeys();
    $values = $this->getValue('resources_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Resources', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Resources', array_values($link));
    }
  }

}
