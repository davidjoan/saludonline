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
      return $this->getQueryFindOneByLowerCaseUsername($username)->fetchOne();        
    }
    
 /*   public function findOneByLowerCaseUsernameAndPassword($username, $password)
    {
    	return $this->getQueryFindOneByLowerCaseUsername($username)->andWhere('p.password = ?', kcCrypt::encrypt($password))->fetchOne();
    }    
    */
    public function getQueryFindOneByLowerCaseUsername($username)
    {
    	$q = $this->createAliasQuery()
    	->where('LOWER(p.username) = ?', strtolower($username));
    	 
    	return $q;
    }
    
    public function getForToken(array $parameters)
    {
       $patient = Doctrine_Core::getTable('Patient') ->findOneByLowerCaseUsername($parameters['username']);
 
       if(!$patient)
       {
       	throw new sfError404Exception(sprintf('EL Usuario "%s" no existe', $parameters['username']));
       }
       elseif (!(sfConfig::get('app_web_service_token') == $parameters['token']))
       {
       	throw new sfError404Exception(sprintf('%s el token no coincide.', $parameters['username']));
       }
       elseif (!($patient->getPassword() == Cipher::getInstance()->encrypt($parameters['password'])))
       {
         throw new sfError404Exception(sprintf('"%s" no conincide tu password.', $parameters['username']));
       }
       else
       {
       	return $patient;
       }
    }
}