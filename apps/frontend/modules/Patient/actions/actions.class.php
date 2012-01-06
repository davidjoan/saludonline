<?php

/**
 * Patient actions.
 *
 * @package    saludonline
 * @subpackage Patient
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PatientActions extends ActionsProject
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $id = $this->getUser()->getUserId();
    $this->object = Doctrine::getTable('Patient')->findOneById($id);
    $this->forward404Unless($this->object);

    $this->form   = new UserFrontendForm($this->object);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter($this->form->getName());
      $this->form->bind($params, $request->getFiles($this->form->getName()));
      $this->form->setDefault('password', '');
      
      if ($this->form->isValid())
      {
        $obj = $this->form->save();
        $this->redirect('@profile_show');
      }
    }  
  }
}
