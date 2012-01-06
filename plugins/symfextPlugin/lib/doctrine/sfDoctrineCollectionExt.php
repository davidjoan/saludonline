<?php

/**
 * sfDoctrineCollectionExt
 *
 * @package    symfext
 * @subpackage doctrine
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfDoctrineCollectionExt extends Doctrine_Collection
{
  public function removeRecord(DoctrineRecord $record)
  {
    $this->remove($this->search($record));
  }
  public function restoreRemoved()
  {
    foreach ($this->getDeleteDiff() as $record)
    {
      $this->add($record);
    }
  }
  
  public function toTemplates($force = true)
  {
    $template_class = $this->getTable()->getComponentName().'Template';
    
    if (class_exists($template_class))
    {
      $templateResults = array();
      foreach ($this as $record)
      {
        $templateResults[] = new $template_class($record);
      }
      
      return $templateResults;
    }
    
    if ($force)
    {
      throw new RuntimeException(sprintf('The "%s" class does not exist. You can\'t convert a sfDoctrineCollectionExt to a collection of templates without the template class', $template_class));
    }
    
    return $this;
  }
  
  public function toCustomArray($fields)
  {
    $array = array();
    $i     = 1; // for problems with the json_encode function, an index must be set explicitly
    
    $templates = $this->toTemplates(false);
    foreach ($templates as $template)
    {
      foreach ($fields as $field => $getter)
      {
        $array[$i][$field] = $template->$getter();
      }
      
      $i++;
    }
    
    return $array;
  }
}
