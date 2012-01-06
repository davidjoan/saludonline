<?php

/**
 * sfValidatorMessageRegex validates a value with a regular expression
 * and set a message with the unallowed characters.
 *
 * @package    symfext
 * @subpackage validator
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfValidatorMessageRegex extends sfValidatorRegex
{
  /**
   * @see sfValidatorString
   */
  protected function doClean($value)
  {
    $clean   = sfValidatorString::doClean($value);
    $pattern = $this->getPattern();
    
    if (preg_match_all($pattern, $clean, $matches))
    {
      throw new sfValidatorError($this, 'invalid', array
      (
        'value' => $value, 
        'chars' => $this->processInvalidChars($matches)
      ));
    }
    
    return $clean;
  }
  /**
   * Returns an string with the processed invalid characters.
   *
   * @param array $matches The array with the invalid characters
   *
   * @return string An string with the processed invalid characters
   */
  protected function processInvalidChars($chars)
  {
    $chars = $chars[0];
    array_walk($chars, create_function('&$v', '$v = Stringkit::str_split($v);'));
    $chars = Toolkit::arrayFlatten($chars);
    $chars = array_unique($chars);
    
    return implode(' ', $chars);
  }
}
