<?php

/**
 * PatientTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PatientTable extends DoctrineTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object PatientTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Patient');
    }
    
    public function findOneByLowerCaseUsername($username)
    {
      $q = $this->createAliasQuery()
         ->where('LOWER(p.username) = ?', strtolower($username));
         
    return $q->fetchOne();        
    }
}