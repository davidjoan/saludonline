<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new FlexiwikBackendTestFunctional(new sfBrowserExt());


$browser->
  info('Generic Module')->
  login()->
  getAndCheck('Generic', 'getAttributeValue', '/generic/get_attribute_value'             , 200)->
  getAndCheck('Generic', 'addDynamicForm'   , '/generic/add_dynamic_form'                , 200)->
  getAndCheck('Generic', 'removeDynamicForm', '/generic/remove_dynamic_form'             , 200)
;
