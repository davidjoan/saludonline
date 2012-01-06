<?php

/**
 * Company form base class.
 *
 * @method Company getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'description'  => new sfWidgetFormTextarea(),
      'address'      => new sfWidgetFormInputText(),
      'phones'       => new sfWidgetFormInputText(),
      'fax'          => new sfWidgetFormInputText(),
      'mobile_phone' => new sfWidgetFormInputText(),
      'mail'         => new sfWidgetFormInputText(),
      'box'          => new sfWidgetFormInputText(),
      'image'        => new sfWidgetFormInputText(),
      'message'      => new sfWidgetFormTextarea(),
      'active'       => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'slug'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'description'  => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'address'      => new sfValidatorString(array('max_length' => 200)),
      'phones'       => new sfValidatorString(array('max_length' => 200)),
      'fax'          => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'mobile_phone' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'mail'         => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'box'          => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'image'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'message'      => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'active'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'slug'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Company', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Company';
  }

}
