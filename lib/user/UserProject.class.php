<?php

/**
 * UserProject
 *
 * @package    saludonline
 * @subpackage user
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class UserProject extends sfUserExt
{
  /**
   * Updates the last access field from the db user.
   * 
   * @see sfUserExt
   */
  public function updateUserLastAccess()
  {
    $user = Doctrine::getTable('User')->find($this->getUserId());
    if ($user)
    {
      // not using the date formatter because this method can be called before the formatter exists
      $user->setLastAccessAt(date('Y-m-d H:i:s'));
      $user->save();
    }
  }
  
  /**
   * Log in the user.
   * 
   * @param User $user The user that logs in.
   */
  public function login(User $user)
  {
    $this->setAttribute('user_id' , $user->getId()      , ActionsProject::USER_NAMESPACE);
    $this->setAttribute('username', $user->getUsername(), ActionsProject::USER_NAMESPACE);
    $this->setAttribute('email'   , $user->getEmail()   , ActionsProject::USER_NAMESPACE);
    $this->setAttribute('slug'    , $user->getSlug()    , ActionsProject::USER_NAMESPACE);
    $this->setAuthenticated(true);
  }
  /**
   * Log out the user.
   * 
   * @param User $user The user that logs out.
   */
  public function logout()
  {
    $this->setAuthenticated(false);
  }
  
  public function getUserId($default = null)
  {
    return $this->getAttribute('user_id' , $default, ActionsProject::USER_NAMESPACE);
  }
  public function getUsername($default = null)
  {
    return $this->getAttribute('username', $default, ActionsProject::USER_NAMESPACE);
  }
  public function getUserEmail($default = null)
  {
    return $this->getAttribute('email'   , $default, ActionsProject::USER_NAMESPACE);
  }
  public function getUserSlug($default = null)
  {
    return $this->getAttribute('slug'    , $default, ActionsProject::USER_NAMESPACE);
  }
  
  public function isFirstRequest($boolean = null)
  {
    if (null === $boolean)
    {
      return $this->getAttribute('first_request', true);
    }
   
    $this->setAttribute('first_request', $boolean);
  }
}
