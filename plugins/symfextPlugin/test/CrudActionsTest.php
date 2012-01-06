<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new FlexiwikBackendTestFunctional(new sfBrowserExt());


$browser->
  info('Crud Module')->
  login()->
  info('The functionality of this module is tested in all the other modules.')
;
