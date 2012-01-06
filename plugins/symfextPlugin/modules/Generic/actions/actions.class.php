<?php

/**
 * Generic actions.
 *
 * @package    symfext
 * @subpackage Generic
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class GenericActions extends ActionsProject
{
  public function executeGetAttributeValue(sfWebRequest $request)
  {
    $attribute = $request->getParameter('attribute');
    $namespace = $request->getParameter('namespace', null);
    $value     = $this->getUser()->getAttribute($attribute, array(), $namespace);
    
    return $this->renderJson($value);
  }
  
  // sfDynamicFormEmbedder
  public function executeAddDynamicForm(sfWebRequest $request)
  {
    $form = sfDynamicFormEmbedder::getProcessedFormTemplate($request->getParameter('name'));
    
    return $this->renderText($form);
  }
  public function executeRemoveDynamicForm(sfWebRequest $request)
  {
    sfDynamicFormEmbedder::addToRemovedList($request->getParameter('name'), $request->getParameter('form_count'));
    
    return sfView::NONE;
  }
}
