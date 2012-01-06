<?php

/**
 * Log actions.
 *
 * @package    saludonline
 * @subpackage Log
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class LogActions extends ActionsProject
{
  public function executeLogin(sfWebRequest $request)
  {
    $this->form = new LoginBackendForm();
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $user = Doctrine::getTable('User')->findOneByLowerCaseEmail($this->form->getValue('email'));
        $this->getUser()->login($user);
        
        return $this->redirect('@home');
      }
      //return sfView::NONE;
    }
    
  }
  public function executeLogout()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->getUser()->logout();
    }
    
    return $this->redirect('@log_login');
  }
}