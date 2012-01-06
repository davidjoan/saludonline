<?php

/**
 * ListColumn
 * 
 * Represents a column from a crud list.
 * 
 * @package    symfext
 * @subpackage util
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class ListColumn
{
  /**
   * Constructor.
   * 
   * @param array $properties The properties for this column
   */
  public function __construct(array $properties)
  {
    $this->initialize($properties);
  }
  
  /**
   * Initializes the columns with all of this properties.
   * 
   * @param array $properties The properties for this column
   */
  public function initialize(array $properties)
  {
    $keys         = array('columnWidth', 'field', 'title', 'method', 'align', 'canSort');
    $defaults     = array('20'         , false  , false  , false   , 'left' , true     );
    $count        = count($keys);
    
    for ($i = 0; $i < $count; $i++)
    {
      $this->$keys[$i] = isset($properties[$i]) ? $properties[$i] : $defaults[$i];
    }
  }
}
