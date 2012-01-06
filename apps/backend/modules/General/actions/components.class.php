<?php

/**
 * General components.
 *
 * @package    saludonline
 * @subpackage General
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class GeneralComponents extends ComponentsProject
{
  public function executeLeftBox()
  {
    $this->visits    = Doctrine::getTable('Visit')->count();
    
    $this->lastVisit = Doctrine::getTable('Visit')->findLast();
  }
}
