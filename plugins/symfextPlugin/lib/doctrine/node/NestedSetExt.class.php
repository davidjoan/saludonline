<?php

/**
 * Doctrine_Node_NestedSetExt
 *
 * @package    symfext
 * @subpackage node
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Doctrine_Node_NestedSetExt extends Doctrine_Node_NestedSet
{
  protected
    $parent = null;
  
  public function setUp()
  {
    parent::setUp();
    $this->_table->setOption('treeImpl', 'NestedSetExt');
  }
  
  public function getParent($refresh = false)
  {
    if (is_null($this->parent) || $refresh)
    {
      $this->parent = parent::getParent();
    }
    
    return $this->parent;
  }
  public function setParent($parent)
  {
    $this->parent = $parent;
  }
  
  public function getChildren()
  {
    $children = parent::getChildren();
    return $children ? $children : array();
  }
  public function getChildrenNumber()
  {
    $children = parent::getChildren();
    return $children ? count($children) : 0;
  }
  public function getAncestors()
  {
    $ancestors = parent::getAncestors();
    return $ancestors ? $ancestors : array();
  }
  
  public function getRoot()
  {
    if ($ancestors = $this->getAncestors())
    {
      return $ancestors->getFirst();
    }
  }
}
