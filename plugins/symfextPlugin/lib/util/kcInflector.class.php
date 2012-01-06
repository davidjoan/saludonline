<?php

/**
 * kcInflector
 *
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class kcInflector extends Doctrine_Inflector
{
  public static function urlize($text)
  {
    return str_replace('-', '_', parent::urlize($text));
  }
  
  public static function constantize($lower_case_and_underscored_word)
  {
    return strtoupper(sfInflector::underscore($lower_case_and_underscored_word));
  }
}
