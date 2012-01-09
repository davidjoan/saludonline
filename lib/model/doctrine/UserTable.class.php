<?php

/**
 * UserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UserTable extends DoctrineTable
{
  public function findOneByLowerCaseEmail($email)
  {
    $q = $this->createAliasQuery()
         ->where('u.email = ?', strtolower($email));
         
    return $q->fetchOne();
  }
}