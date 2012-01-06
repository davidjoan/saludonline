<?php

/**
 * Doctrine_Template_NestedSetExt
 *
 * @package    symfext
 * @subpackage template
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Doctrine_Template_NestedSetExt extends Doctrine_Template_NestedSet
{
  public function setUp()
  {
    parent::setUp();
    $this->_table->setOption('treeImpl', 'NestedSetExt');
  }
}
