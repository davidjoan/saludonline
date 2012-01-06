<?php

/**
 * Contact form base class.
 *
 * @method Contact getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'firstname'     => new sfWidgetFormInputText(),
      'lastname'      => new sfWidgetFormInputText(),
      'gender'        => new sfWidgetFormInputText(),
      'email'         => new sfWidgetFormInputText(),
      'home_phone'    => new sfWidgetFormInputText(),
      'office_phone'  => new sfWidgetFormInputText(),
      'mobile_phone'  => new sfWidgetFormInputText(),
      'rpm'           => new sfWidgetFormInputText(),
      'rpc'           => new sfWidgetFormInputText(),
      'nextel'        => new sfWidgetFormInputText(),
      'fax'           => new sfWidgetFormInputText(),
      'address_home'  => new sfWidgetFormInputText(),
      'address_work'  => new sfWidgetFormInputText(),
      'description'   => new sfWidgetFormTextarea(),
      'prefix'        => new sfWidgetFormInputText(),
      'active'        => new sfWidgetFormInputText(),
      'slug'          => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'patients_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Patient')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'firstname'     => new sfValidatorString(array('max_length' => 100)),
      'lastname'      => new sfValidatorString(array('max_length' => 100)),
      'gender'        => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'email'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'home_phone'    => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'office_phone'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'mobile_phone'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'rpm'           => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'rpc'           => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'nextel'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'fax'           => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'address_home'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'address_work'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'description'   => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'prefix'        => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'active'        => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'slug'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'patients_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Patient', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Contact', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact';
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
