<?php

/**
 * BaseHospital
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $description
 * @property string $type
 * @property string $active
 * @property Doctrine_Collection $Doctors
 * @property Doctrine_Collection $Treatments
 * @property Doctrine_Collection $DoctorHospital
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getCode()           Returns the current record's "code" value
 * @method string              getName()           Returns the current record's "name" value
 * @method string              getAddress()        Returns the current record's "address" value
 * @method string              getPhone()          Returns the current record's "phone" value
 * @method string              getDescription()    Returns the current record's "description" value
 * @method string              getType()           Returns the current record's "type" value
 * @method string              getActive()         Returns the current record's "active" value
 * @method Doctrine_Collection getDoctors()        Returns the current record's "Doctors" collection
 * @method Doctrine_Collection getTreatments()     Returns the current record's "Treatments" collection
 * @method Doctrine_Collection getDoctorHospital() Returns the current record's "DoctorHospital" collection
 * @method Hospital            setId()             Sets the current record's "id" value
 * @method Hospital            setCode()           Sets the current record's "code" value
 * @method Hospital            setName()           Sets the current record's "name" value
 * @method Hospital            setAddress()        Sets the current record's "address" value
 * @method Hospital            setPhone()          Sets the current record's "phone" value
 * @method Hospital            setDescription()    Sets the current record's "description" value
 * @method Hospital            setType()           Sets the current record's "type" value
 * @method Hospital            setActive()         Sets the current record's "active" value
 * @method Hospital            setDoctors()        Sets the current record's "Doctors" collection
 * @method Hospital            setTreatments()     Sets the current record's "Treatments" collection
 * @method Hospital            setDoctorHospital() Sets the current record's "DoctorHospital" collection
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHospital extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_hospital');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('code', 'string', 5, array(
             'type' => 'string',
             'length' => 5,
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'notnull' => true,
             ));
        $this->hasColumn('address', 'string', 400, array(
             'type' => 'string',
             'length' => 400,
             ));
        $this->hasColumn('phone', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('description', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             ));
        $this->hasColumn('type', 'string', 1, array(
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


        $this->index('i_name', array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->index('u_code', array(
             'fields' => 
             array(
              0 => 'code',
             ),
             'type' => 'unique',
             ));
        $this->index('u_name', array(
             'fields' => 
             array(
              0 => 'name',
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
             1 => 'type',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Doctor as Doctors', array(
             'refClass' => 'DoctorHospital',
             'local' => 'hospital_id',
             'foreign' => 'doctor_id'));

        $this->hasMany('Treatment as Treatments', array(
             'local' => 'id',
             'foreign' => 'hospital_id'));

        $this->hasMany('DoctorHospital', array(
             'local' => 'id',
             'foreign' => 'hospital_id'));

        $sluggableext0 = new Doctrine_Template_SluggableExt(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggableext0);
        $this->actAs($timestampable0);
    }
}