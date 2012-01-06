<?php

/**
 * Treatment actions.
 *
 * @package    saludonline
 * @subpackage Treatment
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TreatmentActions extends ActionsProject
{
  public function executeLoadHospitals(sfWebRequest $request)
  {
    $hospitals = Doctrine::getTable('Hospital')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $hospital = $hospitals->toCustomArray(array('id' => 'getId', 'title' => 'getName'));
    return $this->renderJson($hospital);
  }
  
    public function executeLoadDoctors(sfWebRequest $request)
  {
    $doctors = Doctrine::getTable('Doctor')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $doctor = $doctors->toCustomArray(array('id' => 'getId', 'title' => 'getFullName'));
    return $this->renderJson($doctor);
  }
  
  public function executeLoadDiagnosis(sfWebRequest $request)
  {
    $diagnosis = Doctrine::getTable('Diagnosis')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $diag = $diagnosis->toCustomArray(array('id' => 'getId', 'content' => 'getRealName'));
    return $this->renderJson($diag);
  }  
    

  public function executeEdit(sfWebRequest $request)
  {
    $slug = $request->getParameter('slug', ''); 
    $this->object = Doctrine::getTable('Treatment')->findOneBySlug($slug);
    $this->forward404Unless($this->object);

    $this->form   = new TreatmentForm($this->object);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter($this->form->getName());
      $this->form->bind($params, $request->getFiles($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('notice','Se actualizo correctamente su tratamiento.');
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
    $this->object = new Treatment();
    $this->object->setProfile($this->profile);
    
    $this->form   = new TreatmentForm($this->object);

    if ($request->isMethod('post'))
    {
      $params = $request->getParameter($this->form->getName());
      $this->form->bind($params, $request->getFiles($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('notice','Se registro correctamente su tratamiento.');
        $obj = $this->form->save();
      }
    }  
  }  
  
  public function executeDelete(sfWebRequest $request)
  {
    $slugs = $request->getParameter('slug');
    $slugs = explode(',', $slugs);
    $treatment = Doctrine::getTable('Treatment')->findOneBySlug($slugs);
    $parent_slug = $treatment->getProfile()->getSlug();
    $this->forward404Unless($slugs);
    
    try
    {
      Doctrine::getTable('Treatment')->deleteBySlugs($slugs);
    }
    catch (Exception $e)
    {
      $this->redirect('@error_delete_error');
    }
    
    $this->redirect('@profile_show?slug='.$parent_slug);
  } 
}
