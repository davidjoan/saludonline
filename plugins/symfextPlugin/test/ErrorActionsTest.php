<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new FlexiwikBackendTestFunctional(new sfBrowserExt());


$browser->
  info('Error Module')->
  login()->
  getAndCheck('Error', 'deleteError', '/error/delete_error'                              , 200)->
  
  
  info('1.- Actions')->
  info('1.1.- Deleting a record error')->
  get('/attribut/list/name/0/name/a/100/1')->
  get('/attribut/delete/born_date')->
  with('response')->isRedirected()->followRedirect()->
  checkAction('Error', 'deleteError', 200)
;
