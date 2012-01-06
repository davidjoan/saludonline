<?php

/**
 * sfDoctrinePagerExt
 * 
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfDoctrinePagerExt extends sfDoctrinePager
{
  public function getResults($hydrationMode = null)
  {
    $results = parent::getResults($hydrationMode);
    
    try
    {
      $results = $results->toTemplates();
    }
    catch (RuntimeException $e) {}
    
    return $results;
  }
}
