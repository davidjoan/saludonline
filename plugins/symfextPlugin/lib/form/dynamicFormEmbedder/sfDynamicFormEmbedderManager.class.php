<?php

/**
 * sfDynamicFormEmbedderManager manages the creation of a sfDynamicFormEmbedder object. 
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfDynamicFormEmbedderManager
{
  protected
    $relation     = null,
    $foreignAlias = '',
    $dynamicForm  = null;
    
  public function __construct($name, $relation, $label, $parent, $creationCallable = null, $collectionGetterCallable = null)
  {
    $this->initialize($name, $relation, $label, $parent, $creationCallable, $collectionGetterCallable);
  }
  
  public function initialize($name, $relation, $label, $parent, $creationCallable = null, $collectionGetterCallable = null)
  {
    $this->relation            = $relation;
    $this->foreignAlias        = $this->getForeignAlias($relation);
    
    $containerForm             = new DynamicContainerForm();
    $childFormCreationCallable = null === $creationCallable         ? new sfCallable(array($this, 'getNewChildForm')) : $creationCallable;
    $existentChildObjects      = null === $collectionGetterCallable ? $parent->getObject()->{$relation['alias']}      : $collectionGetterCallable->call();
    
    $this->dynamicForm         = new sfDynamicFormEmbedder($name, $relation['alias'], $parent, $containerForm, $existentChildObjects, $childFormCreationCallable);
    $this->dynamicForm->setContainerLabel($label);
    $this->dynamicForm->embed();
    
    sfContext::getInstance()->getEventDispatcher()->connect(sprintf('form.%s.post_configure', $parent->getName()), array($this, 'parentFormPostConfigure'));
  }
  protected function getForeignAlias($relation)
  {
    foreach (Doctrine::getTable($relation['class'])->getRelations() as $rel)
    {
      if ($rel['local'] == $relation['foreign'])
      {
        return $rel['alias'];
      }
    }
  }
  public function getNewChildForm($childObject = null)
  {
    if (null === $childObject)
    {
      $childObject = new $this->relation['class']();
      $childObject->{$this->foreignAlias} = $this->dynamicForm->getParentForm()->getObject();
    }
    
    $childFormClass = $this->relation['class'].'Form';
    $childForm = new $childFormClass($childObject);
    $childForm->deactivateValidation();
    
    return $childForm;
  }
  public function parentFormPostConfigure()
  {
    $this->dynamicForm->saveTemplateForm();
  }
  
  public function getRelation()
  {
    return $this->relation;
  }
  public function getDynamicForm()
  {
    return $this->dynamicForm;
  }
}
