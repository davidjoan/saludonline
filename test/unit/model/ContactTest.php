<?php
require_once dirname(__FILE__).'/../../bootstrap/unit.php';

$configuration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);
new sfDatabaseManager($configuration);


$t = new lime_test(6);

$t->comment('::getFullname() return nombre completo');
$contact  = Doctrine_Core::getTable('Contact')->findOneById(1);
$got      = $contact->getFullname();
$expected ='Nelly Valencia Guinea';
$t->is($got,$expected ,'::getFullname() concatena correctamente el nombre y el apellido');

$got2 = $contact->getGenderStr();
$expected2 ='Femenino';
$t->is($got2,$expected2 ,'::getGenderStr() interpreta correctamente F como Femenino');

$contact->setGender('M');
$got3 = $contact->getGenderStr();
$expected3 ='Masculino';
$t->is($got3,$expected3 ,'::getGenderStr() interpreta correctamente M como Masculino');


$got4 = $contact->getPrefixStr();
$expected4 = 'Sra.';
$t->is($got4,$expected4 ,'::getPrefixStr() interpreta el codigo 2 como Sra.');

$contact->setPrefix(3);
$got5 = $contact->getPrefixStr();
$expected5 = 'Srta.';
$t->is($got5, $expected5 ,'::getPrefixStr() interpreta el codigo 3 como Srta.');


$contact->setPrefix(4);
$got6 = $contact->getPrefixStr();
$expected6 = 'Dr.';
$t->is($got6,$expected6 ,'::getPrefixStr() interpreta el codigo 4 como Dr.');


/*$got7 = $contact->getFormattedCreatedAt('D');
$expected7 = 'Dr.';
$t->is($got7,$expected7 ,'::getFormattedCreatedAt() retorna ');*/