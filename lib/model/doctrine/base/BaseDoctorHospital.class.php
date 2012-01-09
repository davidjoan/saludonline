<?php

/**
 * BaseDoctorHospital
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $doctor_id
 * @property integer $hospital_id
 * @property Doctor $Doctor
 * @property Hospital $Hospital
 * 
 * @method integer        getDoctorId()    Returns the current record's "doctor_id" value
 * @method integer        getHospitalId()  Returns the current record's "hospital_id" value
 * @method Doctor         getDoctor()      Returns the current record's "Doctor" value
 * @method Hospital       getHospital()    Returns the current record's "Hospital" value
 * @method DoctorHospital setDoctorId()    Sets the current record's "doctor_id" value
 * @method DoctorHospital setHospitalId()  Sets the current record's "hospital_id" value
 * @method DoctorHospital setDoctor()      Sets the current record's "Doctor" value
 * @method DoctorHospital setHospital()    Sets the current record's "Hospital" value
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDoctorHospital extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_doctor_hospital');
        $this->hasColumn('doctor_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             ));
        $this->hasColumn('hospital_id', 'integer', 20, array(
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
        $this->hasOne('Doctor', array(
             'local' => 'doctor_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $this->hasOne('Hospital', array(
             'local' => 'hospital_id',
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