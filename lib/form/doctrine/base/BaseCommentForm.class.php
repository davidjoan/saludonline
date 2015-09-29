<?php

/**
 * Comment form base class.
 *
 * @method Comment getObject() Returns the current form's model object
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'post_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Post'), 'add_empty' => false)),
      'user_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'author_name'             => new sfWidgetFormInputText(),
      'author_email'            => new sfWidgetFormInputText(),
      'author_url'              => new sfWidgetFormInputText(),
      'author_twitter_username' => new sfWidgetFormInputText(),
      'author_ip'               => new sfWidgetFormInputText(),
      'content'                 => new sfWidgetFormTextarea(),
      'datetime'                => new sfWidgetFormInputText(),
      'agent'                   => new sfWidgetFormInputText(),
      'approved'                => new sfWidgetFormInputText(),
      'slug'                    => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'post_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Post'))),
      'user_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'author_name'             => new sfValidatorString(array('max_length' => 100)),
      'author_email'            => new sfValidatorString(array('max_length' => 100)),
      'author_url'              => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'author_twitter_username' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'author_ip'               => new sfValidatorString(array('max_length' => 100)),
      'content'                 => new sfValidatorString(array('max_length' => 5000)),
      'datetime'                => new sfValidatorPass(),
      'agent'                   => new sfValidatorString(array('max_length' => 255)),
      'approved'                => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'slug'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Comment', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comment';
  }

}
