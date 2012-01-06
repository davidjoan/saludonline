<?php

/**
 * sfTesterResponseExt
 *
 * @package    symfext
 * @subpackage test
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfTesterResponseExt extends sfTesterResponse
{
  protected
    $jsonContent = array();
  
  /**
   * Initializes the tester.
   */
  public function initialize()
  {
    parent::initialize();
    
    if ($this->response->getContentType() == 'application/json')
    {
      $this->jsonContent = json_decode($this->response->getContent(), true);
    }
  }
  
  /**
   * Tests the length of the array obtained from the json response content.
   *
   * The parameters except the last one, are the keys of the response array.
   * The last parameter is the length to test against the length of the 
   * array obtained using the parameters as keys upon the main array.
   * If there is no keys the main array is used.
   * 
   * @return sfTestFunctionalBase|sfTester
   */
  public function checkJsonLength()
  {
    $args    = func_get_args();
    $length  = array_pop($args);
    $content = $this->getJsonContentAccordingArguments($args);
    
    $this->tester->is(count($content), $length, 'The length of the json reponse is '.$length);
    
    return $this->getObjectToReturn();
  }
  
  /**
   * Tests the content of the array obtained from the json response content.
   *
   * The parameters except the last one, are the keys of the response array.
   * The last parameter is the value to test against the value obtained 
   * using the parameters as keys upon the main array.
   * If there is no keys the main array is used as the value.
   * 
   * @return sfTestFunctionalBase|sfTester
   */
  public function checkJsonResult()
  {
    $args    = func_get_args();
    $value   = array_pop($args);
    $content = $this->getJsonContentAccordingArguments($args);
    
    $this->tester->is($content, $value, 'The parameter is the same as the specified content');
    
    return $this->getObjectToReturn();
  }
  
  /**
   * Returns the value of an array based on the arguments given as parameter.
   * 
   * @param  array  $args  The arguments to be used as keys to obtain the value 
   * 
   * @return mixed  The target content
   */
  protected function getJsonContentAccordingArguments($args)
  {
    switch (count($args))
    {
      case 0: $content = $this->jsonContent                                        ; break;
      case 1: $content = $this->jsonContent[$args[0]]                              ; break;
      case 2: $content = $this->jsonContent[$args[0]][$args[1]]                    ; break;
      case 3: $content = $this->jsonContent[$args[0]][$args[1]][$args[2]]          ; break;
      case 4: $content = $this->jsonContent[$args[0]][$args[1]][$args[2]][$args[3]]; break;
    }
    
    return $content;
  }
}
