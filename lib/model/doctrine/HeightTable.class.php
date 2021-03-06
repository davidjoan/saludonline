<?php

/**
 * HeightTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class HeightTable extends DoctrineTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object HeightTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Height');
    }
  public function findOneBySlug($slug)
  {
    $q = $this->createAliasQuery()
         ->where('h.id = ?', $slug);
         
    return $q->fetchOne();
  }  
  
  public function getQueryForLastHeights($limit, $profile_id, $order = 'DESC')
  {
    $q = $this->createAliasQuery()
         ->orderBy('h.date_of_height '.$order)
         ->limit($limit);
    
    if($profile_id)
    {
        $q->addWhere('h.profile_id = ?', $profile_id);
    }
         
    return $q;
  }
  
  public function findLastHeights($limit = 4, $profile_id = null, $order = 'DESC')
  {
    return $this->getQueryForLastHeights($limit, $profile_id, $order)->execute();
  } 
}