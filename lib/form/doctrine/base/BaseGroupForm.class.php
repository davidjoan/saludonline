<?php

/**
 * Group form base class.
 *
 * @method Group getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'chapter_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Chapter'), 'add_empty' => false)),
      'code'        => new sfWidgetFormInputText(),
      'name'        => new sfWidgetFormTextarea(),
      'description' => new sfWidgetFormTextarea(),
      'active'      => new sfWidgetFormInputText(),
      'slug'        => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'chapter_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Chapter'))),
      'code'        => new sfValidatorString(array('max_length' => 5)),
      'name'        => new sfValidatorString(array('max_length' => 500)),
      'description' => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'active'      => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'slug'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Group', 'column' => array('code'))),
        new sfValidatorDoctrineUnique(array('model' => 'Group', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Group';
  }

}
