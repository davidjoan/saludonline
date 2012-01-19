<?php

/**
 * Api actions.
 *
 * @package    saludonline
 * @subpackage Api
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ApiActions extends sfActions
{
  public function executeLogin(sfWebRequest $request)
  {
  	$this->object = $this->getRoute()->getObject()->asArray();  	
  }
}
