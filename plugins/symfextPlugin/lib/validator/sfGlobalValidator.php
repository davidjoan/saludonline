<?php

/**
 * sfGlobalValidator
 *
 * This validator is the parent of any global validator
 * as pre and post validators.
 *
 * @package    symfext
 * @subpackage validator
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfGlobalValidator extends sfValidatorSchema
{
  /**
   * Constructor.
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorSchema
   */
  public function __construct($options = array(), $messages = array())
  {
    parent::__construct(null, $options, $messages);
  }

  /**
   * Cleans the input value.
   *
   * @throws InvalidArgumentException If the values parameter is not an array
   *
   * @see sfValidatorSchema
   */
  public function clean($values)
  {
    if (!is_array($values))
    {
      throw new InvalidArgumentException('You must pass an array parameter to the clean() method.');
    }

    return parent::clean($values);
  }
  
  /**
   * Returns true if any value is blank.
   *
   * @param array $values The values to evaluate
   * 
   * @return boolean True if any value is blank, otherwise false 
   */
  public function hasEmptyValues($values)
  {
    foreach ($values as $value)
    {
      if (empty($value))
      {
        return true;
      }
    }
  }
}
