<?php

/**
 * UserFrontend.
 *
 * @package    saludonline
 * @subpackage lib.user
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class UserFrontend extends UserProject
{
  public function loginFrontend(Patient $user)
  {
    $this->setAttribute('user_id'  , $user->getId()              , ActionsProject::PATIENT_NAMESPACE);
    $this->setAttribute('username' , $user->getUsername()        , ActionsProject::PATIENT_NAMESPACE);
    $this->setAttribute('realname' , $user->getRealname()        , ActionsProject::PATIENT_NAMESPACE);
    $this->setAttribute('email'    , $user->getEmail()           , ActionsProject::PATIENT_NAMESPACE);
    $this->setAttribute('slug'     , $user->getSlug()            , ActionsProject::PATIENT_NAMESPACE);
    $this->setAttribute('progress' , $user->calculaProgreso()    , ActionsProject::PATIENT_NAMESPACE);
    
    $this->setAuthenticated(true);
  }    
  
  public function updateUserLastAccess()
  {
    $user = Doctrine::getTable('Patient')->find($this->getUserId());
    if ($user)
    {
      // not using the date formatter because this method can be called before the formatter exists
      $user->setLastAccessAt(date('Y-m-d H:i:s'));
      $user->save();
    }
  }
  
  public function getUserId($default = null)
  {
    return $this->getAttribute('user_id' , $default, ActionsProject::PATIENT_NAMESPACE);
  }
  public function getUsername($default = null)
  {
    return $this->getAttribute('username', $default, ActionsProject::PATIENT_NAMESPACE);
  }
  public function getRealname($default = null)
  {
    return $this->getAttribute('realname', $default, ActionsProject::PATIENT_NAMESPACE);
  }  
  public function getUserEmail($default = null)
  {
    return $this->getAttribute('email'   , $default, ActionsProject::PATIENT_NAMESPACE);
  }
  public function getUserSlug($default = null)
  {
    return $this->getAttribute('slug'    , $default, ActionsProject::PATIENT_NAMESPACE);
  }
  public function getProgress($default = null)
  {
    return $this->getAttribute('progress'    , $default, ActionsProject::PATIENT_NAMESPACE);
  }  
}
