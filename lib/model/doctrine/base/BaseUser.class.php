<?php

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $realname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $url
 * @property string $twitter_username
 * @property string $phone
 * @property string $active
 * @property timestamp $last_access_at
 * @property Doctrine_Collection $Posts
 * @property Doctrine_Collection $Comments
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getRealname()         Returns the current record's "realname" value
 * @method string              getUsername()         Returns the current record's "username" value
 * @method string              getPassword()         Returns the current record's "password" value
 * @method string              getEmail()            Returns the current record's "email" value
 * @method string              getUrl()              Returns the current record's "url" value
 * @method string              getTwitterUsername()  Returns the current record's "twitter_username" value
 * @method string              getPhone()            Returns the current record's "phone" value
 * @method string              getActive()           Returns the current record's "active" value
 * @method timestamp           getLastAccessAt()     Returns the current record's "last_access_at" value
 * @method Doctrine_Collection getPosts()            Returns the current record's "Posts" collection
 * @method Doctrine_Collection getComments()         Returns the current record's "Comments" collection
 * @method User                setId()               Sets the current record's "id" value
 * @method User                setRealname()         Sets the current record's "realname" value
 * @method User                setUsername()         Sets the current record's "username" value
 * @method User                setPassword()         Sets the current record's "password" value
 * @method User                setEmail()            Sets the current record's "email" value
 * @method User                setUrl()              Sets the current record's "url" value
 * @method User                setTwitterUsername()  Sets the current record's "twitter_username" value
 * @method User                setPhone()            Sets the current record's "phone" value
 * @method User                setActive()           Sets the current record's "active" value
 * @method User                setLastAccessAt()     Sets the current record's "last_access_at" value
 * @method User                setPosts()            Sets the current record's "Posts" collection
 * @method User                setComments()         Sets the current record's "Comments" collection
 * 
 * @package    saludonline
 * @subpackage model
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUser extends DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('t_user');
        $this->hasColumn('id', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('realname', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'notnull' => true,
             ));
        $this->hasColumn('username', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'notnull' => true,
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'notnull' => true,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'notnull' => true,
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('twitter_username', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('phone', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('active', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => 1,
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('last_access_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));


        $this->index('i_username', array(
             'fields' => 
             array(
              0 => 'username',
             ),
             ));
        $this->index('u_email', array(
             'fields' => 
             array(
              0 => 'email',
             ),
             'type' => 'unique',
             ));
        $this->index('i_url', array(
             'fields' => 
             array(
              0 => 'url',
             ),
             ));
        $this->index('i_twitter_username', array(
             'fields' => 
             array(
              0 => 'twitter_username',
             ),
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
        $this->hasMany('Post as Posts', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Comment as Comments', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $sluggableext0 = new Doctrine_Template_SluggableExt(array(
             'fields' => 
             array(
              0 => 'username',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggableext0);
        $this->actAs($timestampable0);
    }
}