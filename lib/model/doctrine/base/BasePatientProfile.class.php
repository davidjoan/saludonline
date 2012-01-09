<?php

/**
 * BasePatientProfile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $patient_id
 * @property integer $profile_id
 * @property Patient $Patient
 * @property Profile $Profile
 * 
 * @method integer        getPatientId()  Returns the current record's "patient_id" value
 * @method integer        getProfileId()  Returns the current record's "profile_id" value
 * @method Patient        getPatient()    Returns the current record's "Patient" value
 * @method Profile        getProfile()    Returns the current record's "Profile" value
 * @method PatientProfile setPatientId()  Sets the current record's "patient_id" value
 * @method PatientProfile setProfileId()  Sets the current record's "profile_id" value
 * @method PatientProfile setPatient()    Sets the current record's "Patient" value
 * @method PatientProfile setProfile()    Sets the current record's "Profile" value
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePatientProfile extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_patient_profile');
        $this->hasColumn('patient_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             ));
        $this->hasColumn('profile_id', 'integer', 20, array(
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
        $this->hasOne('Patient', array(
             'local' => 'patient_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $this->hasOne('Profile', array(
             'local' => 'profile_id',
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