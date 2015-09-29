<?php

/**
 * Doctor form base class.
 *
 * @method Doctor getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDoctorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'specialty_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Specialty'), 'add_empty' => false)),
      'firstname'      => new sfWidgetFormInputText(),
      'lastname'       => new sfWidgetFormInputText(),
      'gender'         => new sfWidgetFormInputText(),
      'email'          => new sfWidgetFormInputText(),
      'username'       => new sfWidgetFormInputText(),
      'password'       => new sfWidgetFormInputText(),
      'home_phone'     => new sfWidgetFormInputText(),
      'office_phone'   => new sfWidgetFormInputText(),
      'mobile_phone'   => new sfWidgetFormInputText(),
      'fax'            => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'prefix'         => new sfWidgetFormInputText(),
      'active'         => new sfWidgetFormInputText(),
      'last_access_at' => new sfWidgetFormDateTime(),
      'slug'           => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'hospitals_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Hospital')),
      'patients_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Patient')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'specialty_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Specialty'))),
      'firstname'      => new sfValidatorString(array('max_length' => 100)),
      'lastname'       => new sfValidatorString(array('max_length' => 100)),
      'gender'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'email'          => new sfValidatorString(array('max_length' => 100)),
      'username'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'password'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'home_phone'     => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'office_phone'   => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'mobile_phone'   => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'fax'            => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'description'    => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'prefix'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'active'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'last_access_at' => new sfValidatorDateTime(array('required' => false)),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'hospitals_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Hospital', 'required' => false)),
      'patients_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Patient', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Doctor', 'column' => array('email'))),
        new sfValidatorDoctrineUnique(array('model' => 'Doctor', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('doctor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Doctor';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['hospitals_list']))
    {
      $this->setDefault('hospitals_list', $this->object->Hospitals->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['patients_list']))
    {
      $this->setDefault('patients_list', $this->object->Patients->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveHospitalsList($con);
    $this->savePatientsList($con);

    parent::doSave($con);
  }

  public function saveHospitalsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['hospitals_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Hospitals->getPrimaryKeys();
    $values = $this->getValue('hospitals_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Hospitals', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Hospitals', array_values($link));
    }
  }

  public function savePatientsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['patients_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Patients->getPrimaryKeys();
    $values = $this->getValue('patients_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Patients', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Patients', array_values($link));
    }
  }

}
