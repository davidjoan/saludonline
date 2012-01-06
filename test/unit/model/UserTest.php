<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

$configuration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);
new sfDatabaseManager($configuration);
//Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');

$t = new lime_test(2);

$user          = Doctrine_Core::getTable('User')->findOneById(2);

$value_encrypt = kcCrypt::encrypt('a');
$got3          = KcCrypt::compare($value_encrypt,'a');
$expected3     = true;

$got4          = $user->getHiddenPassword();
$expected4     = '***********';

$t->is($got3,$expected3 ,'::encrypt() encripta correctamente el password del usuario');
$t->is($got4, $expected4 , '::getHiddenPassword() retorna siempre ***********');

