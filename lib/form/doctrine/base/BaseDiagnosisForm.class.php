<?php

/**
 * Diagnosis form base class.
 *
 * @method Diagnosis getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDiagnosisForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'group_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Group'), 'add_empty' => false)),
      'code'            => new sfWidgetFormInputText(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'active'          => new sfWidgetFormInputText(),
      'slug'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'treatments_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Treatment')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'group_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Group'))),
      'code'            => new sfValidatorString(array('max_length' => 5)),
      'name'            => new sfValidatorString(array('max_length' => 100)),
      'description'     => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'active'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'slug'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'treatments_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Treatment', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Diagnosis', 'column' => array('code'))),
        new sfValidatorDoctrineUnique(array('model' => 'Diagnosis', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('diagnosis[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Diagnosis';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['treatments_list']))
    {
      $this->setDefault('treatments_list', $this->object->Treatments->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveTreatmentsList($con);

    parent::doSave($con);
  }

  public function saveTreatmentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['treatments_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Treatments->getPrimaryKeys();
    $values = $this->getValue('treatments_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Treatments', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Treatments', array_values($link));
    }
  }

}
