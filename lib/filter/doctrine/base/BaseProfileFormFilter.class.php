<?php

/**
 * Profile filter form base class.
 *
 * @package    saludonline
 * @subpackage filter
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dni'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'firstname'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lastname'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_of_birth'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'gender'         => new sfWidgetFormFilterInput(),
      'image'          => new sfWidgetFormFilterInput(),
      'description'    => new sfWidgetFormFilterInput(),
      'type'           => new sfWidgetFormFilterInput(),
      'blood_type'     => new sfWidgetFormFilterInput(),
      'marital_status' => new sfWidgetFormFilterInput(),
      'active'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'           => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'patients_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Patient')),
    ));

    $this->setValidators(array(
      'dni'            => new sfValidatorPass(array('required' => false)),
      'firstname'      => new sfValidatorPass(array('required' => false)),
      'lastname'       => new sfValidatorPass(array('required' => false)),
      'date_of_birth'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'gender'         => new sfValidatorPass(array('required' => false)),
      'image'          => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'type'           => new sfValidatorPass(array('required' => false)),
      'blood_type'     => new sfValidatorPass(array('required' => false)),
      'marital_status' => new sfValidatorPass(array('required' => false)),
      'active'         => new sfValidatorPass(array('required' => false)),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'patients_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Patient', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /Users/David/Projects/saludonline/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /Users/David/Projects/saludonline/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362
PatientsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.PatientProfile PatientProfile')
      ->andWhereIn('PatientProfile.patient_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Profile';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'dni'            => 'Text',
      'firstname'      => 'Text',
      'lastname'       => 'Text',
      'date_of_birth'  => 'Date',
      'gender'         => 'Text',
      'image'          => 'Text',
      'description'    => 'Text',
      'type'           => 'Text',
      'blood_type'     => 'Text',
      'marital_status' => 'Text',
      'active'         => 'Text',
      'slug'           => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'patients_list'  => 'ManyKey',
    );
  }
}
