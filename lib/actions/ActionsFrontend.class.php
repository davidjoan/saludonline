<?php

/**
 * ActionsCrud
 *
 * @package    saludonline
 * @subpackage action
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
abstract class ActionsFrontend extends sfActionsCrud
{
  protected $method = '';
  
  public function initialize($context, $moduleName, $actionName)
  {
	parent::initialize($context, $moduleName, $actionName);
		 
	$class_name       = get_class($this);
	$class_name       = substr($class_name, 0, strpos($class_name, 'Actions'));
	$this->method     = sprintf('get%ss',$class_name);
	$this->objects    = sprintf('%ss',$class_name);
	$request = sfContext::getInstance()->getRequest();
	$request->setParameter('method' , $this->method);
  }
		
  public function executeIndex(sfWebRequest $request)
  {
	$id = $this->getUser()->getUserId();
	$this->object = Doctrine::getTable('Patient')->findOneById($id);
	$this->forward404Unless($this->object);
	$method = $this->method;
	$this->objects = $this->object->$method();
  }
  
  public function executeDelete(sfWebRequest $request)
  {
  	$slugs   = $request->getParameter('slug');
  	$id      = $this->getUser()->getUserId();
  	$object  = Doctrine::getTable($this->modelClass)->findOneBySlug($slugs);
  	
  	if ($object->getPatients()->getFirst()->getId() <> $id)
  	{
  		$this->forward404();
  	}
  	$slugs = explode(',', $slugs);
  	$this->forward404Unless($slugs);
  
  	try
  	{
  		Doctrine::getTable($this->modelClass)->deleteBySlugs($slugs);
  	}
  	catch (Exception $e)
  	{
  		$this->redirect('@error_delete_error');
  	}
  
  	$this->redirect($this->getEntranceRouteFrontend());
  }  
  
  public function executeEdit(sfWebRequest $request)
  {
  	$slug         = $request->getParameter('slug', '');
  
  	$id = $this->getUser()->getUserId();
  	$this->user = Doctrine::getTable('Patient')->findOneById($id);
  	$this->forward404Unless($this->user);
  	 
  	$this->object = ($slug)?Doctrine::getTable($this->modelClass)->findOneBySlug($slug): new $this->modelClass();
  
  
  	if(!$slug)
  	{
  		$this->object->Patients[] = $this->user;
  	}
  	else
  	{
  		if ($this->object->getPatients()->getFirst()->getSlug() <> $this->user->getSlug())
  		{
  			$this->forward404();
  		}
  	}
  
  	$this->form   = new $this->formClass($this->object);
  
  	if ($request->isMethod('post'))
  	{
  		$params = $request->getParameter($this->form->getName());
  		$this->form->bind($params, $request->getFiles($this->form->getName()));
  
  		if ($this->form->isValid())
  		{
  			$obj = $this->form->save();
  			$this->complementSave($request);
  			$this->redirect($this->getEntranceRouteFrontend());
  		}
  	}
  }  

  public function executeShow(sfWebRequest $request)
  {
  	$slug       = $request->getParameter('slug', '');
  	$id         = $this->getUser()->getUserId();
  	$this->object = Doctrine::getTable($this->modelClass)->findOneBySlug($slug);
  	$this->forward404Unless($this->object);
  
  
  	if ($this->object->getPatients()->getFirst()->getId() <> $id)
  	{
  		$this->forward404();
  	}
  }
}
