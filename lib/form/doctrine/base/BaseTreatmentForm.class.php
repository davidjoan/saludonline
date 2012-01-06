<?php

/**
 * Treatment form base class.
 *
 * @method Treatment getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTreatmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'doctor_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Doctor'), 'add_empty' => false)),
      'profile_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'add_empty' => false)),
      'hospital_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Hospital'), 'add_empty' => false)),
      'date_of_treatment' => new sfWidgetFormDate(),
      'description'       => new sfWidgetFormTextarea(),
      'active'            => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'diagnosises_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Diagnosis')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'doctor_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Doctor'))),
      'profile_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'))),
      'hospital_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Hospital'))),
      'date_of_treatment' => new sfValidatorDate(array('required' => false)),
      'description'       => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'active'            => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'diagnosises_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Diagnosis', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('treatment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Treatment';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['diagnosises_list']))
    {
      $this->setDefault('diagnosises_list', $this->object->Diagnosises->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDiagnosisesList($con);

    parent::doSave($con);
  }

  public function saveDiagnosisesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['diagnosises_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Diagnosises->getPrimaryKeys();
    $values = $this->getValue('diagnosises_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Diagnosises', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Diagnosises', array_values($link));
    }
  }

}
