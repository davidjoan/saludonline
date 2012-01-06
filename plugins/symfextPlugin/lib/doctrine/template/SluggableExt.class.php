<?php

/**
 * Doctrine_Template_SluggableExt
 *
 * Easily create a slug for each record based on a specified set of fields
 *
 * @package    symfext
 * @subpackage template
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Doctrine_Template_SluggableExt extends Doctrine_Template_Sluggable
{
  public function __construct(array $options = array())
  {
    $config  = array
               (
                 'builder'   => array('kcInflector', 'urlize'),
                 'canUpdate' => true,
               );
    $options = array_merge($config, $options);
    
    parent::__construct($options);
  }
}