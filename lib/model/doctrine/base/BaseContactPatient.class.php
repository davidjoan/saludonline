<?php

/**
 * BaseContactPatient
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $contact_id
 * @property integer $patient_id
 * @property Contact $Contact
 * @property Patient $Patient
 * 
 * @method integer        getContactId()  Returns the current record's "contact_id" value
 * @method integer        getPatientId()  Returns the current record's "patient_id" value
 * @method Contact        getContact()    Returns the current record's "Contact" value
 * @method Patient        getPatient()    Returns the current record's "Patient" value
 * @method ContactPatient setContactId()  Sets the current record's "contact_id" value
 * @method ContactPatient setPatientId()  Sets the current record's "patient_id" value
 * @method ContactPatient setContact()    Sets the current record's "Contact" value
 * @method ContactPatient setPatient()    Sets the current record's "Patient" value
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseContactPatient extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_contact_patient');
        $this->hasColumn('contact_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             ));
        $this->hasColumn('patient_id', 'integer', 20, array(
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
        $this->hasOne('Contact', array(
             'local' => 'contact_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $this->hasOne('Patient', array(
             'local' => 'patient_id',
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