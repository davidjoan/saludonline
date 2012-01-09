<?php

/**
 * BaseCompany
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property string $phones
 * @property string $fax
 * @property string $mobile_phone
 * @property string $mail
 * @property string $box
 * @property string $image
 * @property string $message
 * @property string $active
 * 
 * @method integer getId()           Returns the current record's "id" value
 * @method string  getName()         Returns the current record's "name" value
 * @method string  getDescription()  Returns the current record's "description" value
 * @method string  getAddress()      Returns the current record's "address" value
 * @method string  getPhones()       Returns the current record's "phones" value
 * @method string  getFax()          Returns the current record's "fax" value
 * @method string  getMobilePhone()  Returns the current record's "mobile_phone" value
 * @method string  getMail()         Returns the current record's "mail" value
 * @method string  getBox()          Returns the current record's "box" value
 * @method string  getImage()        Returns the current record's "image" value
 * @method string  getMessage()      Returns the current record's "message" value
 * @method string  getActive()       Returns the current record's "active" value
 * @method Company setId()           Sets the current record's "id" value
 * @method Company setName()         Sets the current record's "name" value
 * @method Company setDescription()  Sets the current record's "description" value
 * @method Company setAddress()      Sets the current record's "address" value
 * @method Company setPhones()       Sets the current record's "phones" value
 * @method Company setFax()          Sets the current record's "fax" value
 * @method Company setMobilePhone()  Sets the current record's "mobile_phone" value
 * @method Company setMail()         Sets the current record's "mail" value
 * @method Company setBox()          Sets the current record's "box" value
 * @method Company setImage()        Sets the current record's "image" value
 * @method Company setMessage()      Sets the current record's "message" value
 * @method Company setActive()       Sets the current record's "active" value
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCompany extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_company');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('description', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             'notnull' => false,
             ));
        $this->hasColumn('address', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => true,
             ));
        $this->hasColumn('phones', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => true,
             ));
        $this->hasColumn('fax', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('mobile_phone', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('mail', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('box', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('image', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => false,
             ));
        $this->hasColumn('message', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             ));
        $this->hasColumn('active', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => 1,
             'notnull' => true,
             'default' => 0,
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
        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggableext0 = new Doctrine_Template_SluggableExt(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggableext0);
    }
}