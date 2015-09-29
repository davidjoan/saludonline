<?php

/**
 * BaseTreatmentDiagnosis
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $treatment_id
 * @property integer $diagnosis_id
 * @property Treatment $Treatment
 * @property Diagnosis $Diagnosis
 * 
 * @method integer            getTreatmentId()  Returns the current record's "treatment_id" value
 * @method integer            getDiagnosisId()  Returns the current record's "diagnosis_id" value
 * @method Treatment          getTreatment()    Returns the current record's "Treatment" value
 * @method Diagnosis          getDiagnosis()    Returns the current record's "Diagnosis" value
 * @method TreatmentDiagnosis setTreatmentId()  Sets the current record's "treatment_id" value
 * @method TreatmentDiagnosis setDiagnosisId()  Sets the current record's "diagnosis_id" value
 * @method TreatmentDiagnosis setTreatment()    Sets the current record's "Treatment" value
 * @method TreatmentDiagnosis setDiagnosis()    Sets the current record's "Diagnosis" value
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTreatmentDiagnosis extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_treatment_diagnosis');
        $this->hasColumn('treatment_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             ));
        $this->hasColumn('diagnosis_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             ));

        $this->option('symfony', array(
             'filter' => false,
             'form' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Treatment', array(
             'local' => 'treatment_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $this->hasOne('Diagnosis', array(
             'local' => 'diagnosis_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}