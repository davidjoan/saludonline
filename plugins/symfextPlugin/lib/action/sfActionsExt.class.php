<?php

/**
 * sfActionsExt
 *
 * @package    symfext
 * @subpackage action
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
abstract class sfActionsExt extends sfActions
{
  const
    CRUD_NAMESPACE                     = 'Crud',
    ERROR_NAMESPACE                    = 'Error',
    GENERIC_NAMESPACE                  = 'Generic',
    PAGER_NAMESPACE                    = 'Pager';
  
  protected function getEntranceRoute($module = null)
  {
    $module = $module ? $module : sfContext::getInstance()->getRequest()->getParameter('module');
    
    return Toolkit::getEntranceRoute($module);
  }
  
  protected function getEntranceRouteFrontend($module = null)
  {
  	$module = $module ? $module : sfContext::getInstance()->getRequest()->getParameter('module');
  
  	return Toolkit::getEntranceRouteFrontend($module);
  }  
  
  protected function renderJson($value)
  {
    $this->getResponse()->setContentType('application/json');
    
    return $this->renderText(json_encode($value));
  }
  
  protected function loadHelpers($helpers)
  {
    Toolkit::loadHelpers($helpers);
  }
  
  protected function getRouting()
  {
    return sfContext::getInstance()->getRouting();
  }
}
