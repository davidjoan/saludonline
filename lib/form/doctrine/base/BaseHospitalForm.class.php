<?php

/**
 * Hospital form base class.
 *
 * @method Hospital getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHospitalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'code'         => new sfWidgetFormInputText(),
      'name'         => new sfWidgetFormInputText(),
      'address'      => new sfWidgetFormTextarea(),
      'phone'        => new sfWidgetFormInputText(),
      'description'  => new sfWidgetFormTextarea(),
      'type'         => new sfWidgetFormInputText(),
      'active'       => new sfWidgetFormInputText(),
      'slug'         => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'doctors_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Doctor')),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'code'         => new sfValidatorString(array('max_length' => 5)),
      'name'         => new sfValidatorString(array('max_length' => 100)),
      'address'      => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'phone'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'description'  => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'type'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'active'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'slug'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'doctors_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Doctor', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Hospital', 'column' => array('code'))),
        new sfValidatorDoctrineUnique(array('model' => 'Hospital', 'column' => array('name'))),
        new sfValidatorDoctrineUnique(array('model' => 'Hospital', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('hospital[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Hospital';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['doctors_list']))
    {
      $this->setDefault('doctors_list', $this->object->Doctors->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDoctorsList($con);

    parent::doSave($con);
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

}
