<?php

/**
 * Profile form base class.
 *
 * @method Profile getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'dni'            => new sfWidgetFormInputText(),
      'firstname'      => new sfWidgetFormInputText(),
      'lastname'       => new sfWidgetFormInputText(),
      'date_of_birth'  => new sfWidgetFormDate(),
      'gender'         => new sfWidgetFormInputText(),
      'image'          => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'type'           => new sfWidgetFormInputText(),
      'blood_type'     => new sfWidgetFormInputText(),
      'marital_status' => new sfWidgetFormInputText(),
      'active'         => new sfWidgetFormInputText(),
      'slug'           => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'patients_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Patient')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dni'            => new sfValidatorString(array('max_length' => 8)),
      'firstname'      => new sfValidatorString(array('max_length' => 100)),
      'lastname'       => new sfValidatorString(array('max_length' => 100)),
      'date_of_birth'  => new sfValidatorDate(array('required' => false)),
      'gender'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'image'          => new sfValidatorString(array('max_length' => 105)),
      'description'    => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'type'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'blood_type'     => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'marital_status' => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'active'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'patients_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Patient', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Profile', 'column' => array('dni'))),
        new sfValidatorDoctrineUnique(array('model' => 'Profile', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['patients_list']))
    {
      $this->setDefault('patients_list', $this->object->Patients->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePatientsList($con);

    parent::doSave($con);
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
