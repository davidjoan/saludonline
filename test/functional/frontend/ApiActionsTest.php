<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctionalExt(new sfBrowser());

$browser->
info('1 - Web service security')->

info('  1.1 - A token is needed to access the service')->
get('/api/Whex1df$fB2537hyhdtm/davidjoan/jasmin1.json')->
with('response')->isStatusCode(404)->

info('  1.2 - An user not exists')->
get('/api/Whex1df$fB2537hyhdtm/davjoan/jasmin1.json')->
with('response')->isStatusCode(404)->

info('2 - Error in password')->
get('/api/Whex1df$fB2537hyhdtm/davidjoan/jan1.json')->
with('response')->isStatusCode(404)->

info('3 - The web service supports the JSON format')->
get('/api/Whex1dfqat$$fB2537hyhdtm/davidjoan/jasmin1.json')->
with('request')->isFormat('json')->
with('response')->matches('/"username"\: "davidjoan"/');