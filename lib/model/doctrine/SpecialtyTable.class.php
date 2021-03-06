<?php

/**
 * SpecialtyTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SpecialtyTable extends DoctrineTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object SpecialtyTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Specialty');
    }
 const
    STATUS_ACTIVE       = 1,
    STATUS_INACTIVE     = 0;
    
  protected static
    $status                = array
                             (
                               self::STATUS_ACTIVE     => 'Yes',
                               self::STATUS_INACTIVE   => 'No',
                             );
                             
  public function getStatuss()
  {
    return self::$status;
  }	    
}