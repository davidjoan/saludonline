<?php

/**
 * Panel actions.
 *
 * @package    saludonline
 * @subpackage Panel
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PanelActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     $id = $this->getUser()->getUserId();
     $this->user = Doctrine::getTable('Patient')->findOneById($id);
     $this->company = Doctrine::getTable('Company')->findOneById(1);
     $this->forward404Unless($this->user);
     $this->profiles = $this->user->getProfiles();
  }
}
