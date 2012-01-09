<?php

/**
 * DiagnosisTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DiagnosisTable extends DoctrineTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object DiagnosisTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Diagnosis');
    }
  public function findByNameLike($name, $limit = 20)
  {
    $q = $this->createAliasQuery('d')

         ->where('LOWER(d.name) LIKE ?', '%'.Stringkit::strtolower($name).'%')
        //  ->orwhere('LOWER(d.lastname) LIKE ?', '%'.Stringkit::strtolower($name).'%')
         ->limit($limit);
    
    return $q->execute();
  }     
}