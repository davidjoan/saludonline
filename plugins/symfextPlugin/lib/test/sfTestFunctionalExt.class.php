<?php

/**
 * sfTestFunctionalExt tests an application by using a browser simulator.
 *
 * @package    symfext
 * @subpackage test
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfTestFunctionalExt extends sfTestFunctional
{
  public function __construct(sfBrowserBase $browser, lime_test $lime = null, $testers = array())
  {
    $testers = array_merge
    (
      array
      (
        'doctrine'    => 'sfTesterDoctrineExt', 
        'file_system' => 'sfTesterFileSystem',
        'response'    => 'sfTesterResponseExt',
      ), 
      $testers
    );
               
    if (null === self::$test)
    {
      self::$test = null !== $lime ? $lime : new lime_test_ext();
    }
    
    parent::__construct($browser, $lime, $testers);
  }
  
  public function checkAction($module, $action, $code = 200)
  {
    return $this->
           with('request')->begin()->
             isParameter('module', $module)->
             isParameter('action', $action)->
           end()->
           with('response')->isStatusCode($code);
  }
}
