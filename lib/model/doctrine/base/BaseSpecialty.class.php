<?php

/**
 * BaseSpecialty
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $active
 * @property Doctrine_Collection $Doctors
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getCode()        Returns the current record's "code" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getActive()      Returns the current record's "active" value
 * @method Doctrine_Collection getDoctors()     Returns the current record's "Doctors" collection
 * @method Specialty           setId()          Sets the current record's "id" value
 * @method Specialty           setCode()        Sets the current record's "code" value
 * @method Specialty           setName()        Sets the current record's "name" value
 * @method Specialty           setDescription() Sets the current record's "description" value
 * @method Specialty           setActive()      Sets the current record's "active" value
 * @method Specialty           setDoctors()     Sets the current record's "Doctors" collection
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSpecialty extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_specialty');
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
        $this->hasColumn('description', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
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
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Doctor as Doctors', array(
             'local' => 'id',
             'foreign' => 'specialty_id'));

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