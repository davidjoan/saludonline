<?php

/**
 * BaseChapter
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $active
 * @property Doctrine_Collection $Groups
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getCode()        Returns the current record's "code" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getActive()      Returns the current record's "active" value
 * @method Doctrine_Collection getGroups()      Returns the current record's "Groups" collection
 * @method Chapter             setId()          Sets the current record's "id" value
 * @method Chapter             setCode()        Sets the current record's "code" value
 * @method Chapter             setName()        Sets the current record's "name" value
 * @method Chapter             setDescription() Sets the current record's "description" value
 * @method Chapter             setActive()      Sets the current record's "active" value
 * @method Chapter             setGroups()      Sets the current record's "Groups" collection
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseChapter extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_chapter');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('code', 'string', 15, array(
             'type' => 'string',
             'length' => 15,
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
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
        $this->hasMany('Group as Groups', array(
             'local' => 'id',
             'foreign' => 'chapter_id'));

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