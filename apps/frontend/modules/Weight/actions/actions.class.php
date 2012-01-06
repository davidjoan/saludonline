<?php

/**
 * Weight actions.
 *
 * @package    saludonline
 * @subpackage Weight
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class WeightActions extends ActionsProject
{

  public function executeEdit(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug', ''); 
    $this->object = Doctrine::getTable('Weight')->findOneBySlug($slug);
    $this->forward404Unless($this->object);

    $this->form   = new WeightForm($this->object);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter($this->form->getName());
      $this->form->bind($params, $request->getFiles($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('notice','Se actualizo correctamente su peso.');
        $obj = $this->form->save();
      }
    }  
  }
  
  public function executeNew(sfWebRequest $request)
  {
    sfConfig::set('sf_web_debug', false);
    $slug = $request->getParameter('slug', ''); 
    $this->profile = Doctrine::getTable('Profile')->findOneBySlug($slug);
    $this->forward404Unless($this->profile);
    $this->object = new Weight();
    $this->object->setProfile($this->profile);
    
    $this->form   = new WeightForm($this->object);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter($this->form->getName());
      $this->form->bind($params, $request->getFiles($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('notice','Se registro correctamente su peso.');
        $obj = $this->form->save();
      }
    }  
  }  
  
  public function executeDelete(sfWebRequest $request)
  {
    $slugs = $request->getParameter('slug');
    $slugs = explode(',', $slugs);
    $weigth = Doctrine::getTable('Weight')->findOneBySlug($slugs);
    $parent_slug = $weigth->getProfile()->getSlug();
    $this->forward404Unless($slugs);
    
    try
    {
      Doctrine::getTable('Weight')->deleteBySlugs($slugs);
    }
    catch (Exception $e)
    {
      $this->redirect('@error_delete_error');
    }
    
    $this->redirect('@profile_show?slug='.$parent_slug);
  }    
}
