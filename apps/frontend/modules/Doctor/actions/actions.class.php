<?php

/**
 * Doctor actions.
 *
 * @package    saludonline
 * @subpackage Doctor
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DoctorActions extends ActionsFrontend
{
  public function executeLoadHospitals(sfWebRequest $request)
  {
    $hospitals = Doctrine::getTable('Hospital')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $hospital = $hospitals->toCustomArray(array('id' => 'getId', 'content' => 'getName'));
    return $this->renderJson($hospital);
  }
}