<?php

/**
 * Weight form base class.
 *
 * @method Weight getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWeightForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'profile_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'), 'add_empty' => false)),
      'current_weight'  => new sfWidgetFormInputText(),
      'expected_weight' => new sfWidgetFormInputText(),
      'date_of_weight'  => new sfWidgetFormDate(),
      'description'     => new sfWidgetFormTextarea(),
      'active'          => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profile_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profile'))),
      'current_weight'  => new sfValidatorNumber(array('required' => false)),
      'expected_weight' => new sfValidatorNumber(array('required' => false)),
      'date_of_weight'  => new sfValidatorDate(array('required' => false)),
      'description'     => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'active'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('weight[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Weight';
  }

}
