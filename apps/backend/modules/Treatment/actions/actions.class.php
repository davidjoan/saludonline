<?php

/**
 * Treatment actions.
 *
 * @package    saludonline
 * @subpackage Treatment
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TreatmentActions extends ActionsCrud
{
  public function executeLoadDoctors(sfWebRequest $request)
  {
    $doctors = Doctrine::getTable('Doctor')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $doctor = $doctors->toCustomArray(array('id' => 'getId', 'title' => 'getFullName'));
    return $this->renderJson($doctor);
  }
  public function executeLoadHospitals(sfWebRequest $request)
  {
    $doctors = Doctrine::getTable('Hospital')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $doctor = $doctors->toCustomArray(array('id' => 'getId', 'title' => 'getName'));
    return $this->renderJson($doctor);
  }  
  
  public function executeLoadDiagnosis(sfWebRequest $request)
  {
    $diagnosis = Doctrine::getTable('Diagnosis')->findByNameLike($request->getParameter('term'), $request->getParameter('limit'));
    $diag = $diagnosis->toCustomArray(array('id' => 'getId', 'content' => 'getName'));
    return $this->renderJson($diag);
  }      
}
