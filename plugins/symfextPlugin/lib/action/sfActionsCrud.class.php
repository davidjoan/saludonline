<?php

/**
 * sfActionsCrud
 *
 * @package    symfext
 * @subpackage action
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
abstract class sfActionsCrud extends ActionsProject
{
  protected
    $usClass    = '', // underscore class name
    $modelClass = '',
    $tableClass = '',
    $formClass  = '',
    $namespace  = '';
    
  public function initialize($context, $moduleName, $actionName)
  {
  	parent::initialize($context, $moduleName, $actionName);
  	
    $class_name       = get_class($this);
    $class_name       = substr($class_name, 0, strpos($class_name, 'Actions'));
    $this->usClass    = sfInflector::underscore($class_name);
    $this->modelClass = $class_name;
    $this->tableClass = $this->modelClass.'Table';
    $this->formClass  = $this->modelClass.'Form';
    $this->namespace  = constant(sprintf('self::%s_NAMESPACE', strtoupper($this->usClass)));
    
    $request = sfContext::getInstance()->getRequest();
    $request->setParameter('usClass'   , $this->usClass);
    $request->setParameter('modelClass', $this->modelClass);
    $request->setParameter('tableClass', $this->tableClass);
    $request->setParameter('formClass' , $this->formClass);
    $request->setParameter('namespace' , $this->namespace);
  }
  
  public function executeList(sfWebRequest $request)
  {
    $q = Doctrine::getTable($this->modelClass)->createAliasQuery();
    $q->filterAndArrange($this->getFilterAndArrangeParameters($request), $this->getExtraFilterAndArrangeFields());
    $this->complementList($request, $q);
    $this->configureList($request, $q);
    $this->setPager($request, $q);
  }
  protected function getFilterAndArrangeParameters(sfWebRequest $request)
  {
    return $request->getParameterHolder()->getAll();
  }
  protected function getExtraFilterAndArrangeFields()
  {
    return array();
  }
  protected function complementList(sfWebRequest $request, DoctrineQuery $q)
  {
  }
  protected function configureList(sfWebRequest $request)
  {
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $slug         = $request->getParameter('slug', '');
    $this->object = Doctrine::getTable($this->modelClass)->findOneBySlug($slug);
    $this->complementObject($request);
    $this->form   = new $this->formClass($this->object);
    $this->complementEdit($request);
    if ($request->isMethod('post'))
    {
      //Deb::print_r($request->getFiles($this->form->getName()));
      $params = $request->getParameter($this->form->getName());
      $this->form->bind($params, $request->getFiles($this->form->getName()));
      
      if ($this->form->isValid())
      {
        $obj = $this->form->save();
        $this->complementSave($request);
        $this->redirect($this->getEntranceRoute());
      }
    }
  }
  protected function complementObject(sfWebRequest $request)
  {
  }
  protected function complementEdit(sfWebRequest $request)
  {
  }
  protected function complementSave(sfWebRequest $request)
  {
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $slugs = $request->getParameter('slug');
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
    
    $this->redirect($this->getEntranceRoute());
  }
  
  protected function setPager(sfWebRequest $request, DoctrineQuery $q)
  {
  	$pager = new sfDoctrinePagerExt($this->modelClass, $request->getParameter('max'));
  	$pager->setPage($request->getParameter('page'));
  	$pager->setQuery($q);
  	$pager->init();
  	$this->pager = $pager;
  }
  
  
  public function executeSort(sfWebRequest $request)
  {
    $order = $request->getParameter('item', array());
    
    Doctrine::getTable($this->modelClass)->sort($order);
    
    return sfView::NONE;
  }
}
