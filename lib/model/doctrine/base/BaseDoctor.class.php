<?php

/**
 * BaseDoctor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $specialty_id
 * @property string $firstname
 * @property string $lastname
 * @property string $gender
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $home_phone
 * @property string $office_phone
 * @property string $mobile_phone
 * @property string $fax
 * @property string $description
 * @property string $prefix
 * @property string $active
 * @property timestamp $last_access_at
 * @property Doctrine_Collection $Treatments
 * @property Doctrine_Collection $Hospitals
 * @property Doctrine_Collection $Patients
 * @property Specialty $Specialty
 * @property Doctrine_Collection $DoctorHospital
 * @property Doctrine_Collection $DoctorPatient
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method integer             getSpecialtyId()    Returns the current record's "specialty_id" value
 * @method string              getFirstname()      Returns the current record's "firstname" value
 * @method string              getLastname()       Returns the current record's "lastname" value
 * @method string              getGender()         Returns the current record's "gender" value
 * @method string              getEmail()          Returns the current record's "email" value
 * @method string              getUsername()       Returns the current record's "username" value
 * @method string              getPassword()       Returns the current record's "password" value
 * @method string              getHomePhone()      Returns the current record's "home_phone" value
 * @method string              getOfficePhone()    Returns the current record's "office_phone" value
 * @method string              getMobilePhone()    Returns the current record's "mobile_phone" value
 * @method string              getFax()            Returns the current record's "fax" value
 * @method string              getDescription()    Returns the current record's "description" value
 * @method string              getPrefix()         Returns the current record's "prefix" value
 * @method string              getActive()         Returns the current record's "active" value
 * @method timestamp           getLastAccessAt()   Returns the current record's "last_access_at" value
 * @method Doctrine_Collection getTreatments()     Returns the current record's "Treatments" collection
 * @method Doctrine_Collection getHospitals()      Returns the current record's "Hospitals" collection
 * @method Doctrine_Collection getPatients()       Returns the current record's "Patients" collection
 * @method Specialty           getSpecialty()      Returns the current record's "Specialty" value
 * @method Doctrine_Collection getDoctorHospital() Returns the current record's "DoctorHospital" collection
 * @method Doctrine_Collection getDoctorPatient()  Returns the current record's "DoctorPatient" collection
 * @method Doctor              setId()             Sets the current record's "id" value
 * @method Doctor              setSpecialtyId()    Sets the current record's "specialty_id" value
 * @method Doctor              setFirstname()      Sets the current record's "firstname" value
 * @method Doctor              setLastname()       Sets the current record's "lastname" value
 * @method Doctor              setGender()         Sets the current record's "gender" value
 * @method Doctor              setEmail()          Sets the current record's "email" value
 * @method Doctor              setUsername()       Sets the current record's "username" value
 * @method Doctor              setPassword()       Sets the current record's "password" value
 * @method Doctor              setHomePhone()      Sets the current record's "home_phone" value
 * @method Doctor              setOfficePhone()    Sets the current record's "office_phone" value
 * @method Doctor              setMobilePhone()    Sets the current record's "mobile_phone" value
 * @method Doctor              setFax()            Sets the current record's "fax" value
 * @method Doctor              setDescription()    Sets the current record's "description" value
 * @method Doctor              setPrefix()         Sets the current record's "prefix" value
 * @method Doctor              setActive()         Sets the current record's "active" value
 * @method Doctor              setLastAccessAt()   Sets the current record's "last_access_at" value
 * @method Doctor              setTreatments()     Sets the current record's "Treatments" collection
 * @method Doctor              setHospitals()      Sets the current record's "Hospitals" collection
 * @method Doctor              setPatients()       Sets the current record's "Patients" collection
 * @method Doctor              setSpecialty()      Sets the current record's "Specialty" value
 * @method Doctor              setDoctorHospital() Sets the current record's "DoctorHospital" collection
 * @method Doctor              setDoctorPatient()  Sets the current record's "DoctorPatient" collection
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDoctor extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_doctor');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('specialty_id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'notnull' => true,
             ));
        $this->hasColumn('firstname', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'notnull' => true,
             ));
        $this->hasColumn('lastname', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'notnull' => true,
             ));
        $this->hasColumn('gender', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => 1,
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'notnull' => true,
             ));
        $this->hasColumn('username', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'notnull' => false,
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'notnull' => false,
             ));
        $this->hasColumn('home_phone', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('office_phone', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('mobile_phone', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('fax', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('description', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             'notnull' => false,
             ));
        $this->hasColumn('prefix', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => 1,
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('active', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => 1,
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('last_access_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));


        $this->index('i_firstname', array(
             'fields' => 
             array(
              0 => 'firstname',
             ),
             ));
        $this->index('i_lastname', array(
             'fields' => 
             array(
              0 => 'lastname',
             ),
             ));
        $this->index('u_email', array(
             'fields' => 
             array(
              0 => 'email',
             ),
             'type' => 'unique',
             ));
        $this->index('i_active', array(
             'fields' => 
             array(
              0 => 'active',
             ),
             ));
        $this->option('symfony', array(
             'filter' => false,
             'form' => true,
             ));
        $this->option('boolean_columns', array(
             0 => 'active',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Treatment as Treatments', array(
             'local' => 'id',
             'foreign' => 'doctor_id'));

        $this->hasMany('Hospital as Hospitals', array(
             'refClass' => 'DoctorHospital',
             'local' => 'doctor_id',
             'foreign' => 'hospital_id'));

        $this->hasMany('Patient as Patients', array(
             'refClass' => 'DoctorPatient',
             'local' => 'doctor_id',
             'foreign' => 'patient_id'));

        $this->hasOne('Specialty', array(
             'local' => 'specialty_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT',
             'onUpdate' => 'CASCADE'));

        $this->hasMany('DoctorHospital', array(
             'local' => 'id',
             'foreign' => 'doctor_id'));

        $this->hasMany('DoctorPatient', array(
             'local' => 'id',
             'foreign' => 'doctor_id'));

        $sluggableext0 = new Doctrine_Template_SluggableExt(array(
             'fields' => 
             array(
              0 => 'firstname',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggableext0);
        $this->actAs($timestampable0);
    }
}