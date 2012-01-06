<?php

/**
 * Treatment form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TreatmentForm extends BaseTreatmentForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'hospital_id'       => 'Hospital',
      'doctor_id'         => 'Doctor',
      'date_of_treatment' => 'Fecha de Tratamiento',
      'description'       => 'Descripción',
      'diagnosises_list'  => 'Diagnosticos',        
    );
  }
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                      => new sfWidgetFormInputHidden(),
      'hospital_id'             => new sfWidgetFormJQueryCompleter(array
                                (
                                  'url'             => $this->genUrl('@treatment_load_hospital'),
                                  'value_callback'  => array($this, 'getHospitalName'),
                                  'config'          => sprintf('{ max: "20" }')
                                ), array('size' => 50)),        
      'doctor_id'               => new sfWidgetFormJQueryCompleter(array
                                (
                                  'url'             => $this->genUrl('@treatment_load_doctor'),
                                  'value_callback'  => array($this, 'getFullName'),
                                  'config'          => sprintf('{ max: "20" }')
                                ), array('size' => 50)),
      'date_of_treatment'       => new sfWidgetFormDateExt(array
                                (
                                  'format'     => $this->widgetFormatter->getStandardDateFormat(),
                                  'year_start' => 1920,
                                  'year_end'   => date('Y'),
                                )),
      'diagnosises_list'        => new sfWidgetFormJQueryCompleterDoubleList(array
                                (
                                 'selected'   => $this->getDiagnosises(),
                                 'search_url' => $this->genUrl('@treatment_load_diagnosis'),
                                 'label_selected' => 'Seleccionados',
                                 'label_autocompleter' => 'Buscar',
                                 'search_config'          => sprintf('{ max: "30" }')
                                )),
      'description'             => new sfWidgetFormTextareaTinyMCE(array
                                    (
                                      'width'            => 350,
                                      'height'           => 150,
                                      'config'           => 'theme_advanced_buttons2 : ""',
                                    )), 
    ));    
    
    $this->types = array
    (
      'id'                => '=',
      'doctor_id'         => 'combo',
      'hospital_id'       => 'combo',
      'profile_id'        => '-',
      'date_of_treatment' => 'date',
      'description'       => '=',
      'active'            => '-',
      'created_at'        => '-',
      'updated_at'        => '-',
      'diagnosises_list'  => 'list'
    );    

  
    $this->setDefault('date_of_treatment', date('Y-m-d'));

    $this->widgetSchema->setFormFormatterName('frontend');      
  }
  
  public function getFullName($doctor_id)
  {
    $name = '';
    if ($doctor_id)
    {
      $doctor = Doctrine::getTable('Doctor')->findOneById($doctor_id);
      
      $name   = $doctor ? $doctor->getFullName() : '';
    }
    
    return $name;
  }  
  
  public function getHospitalName($hospital_id)
  {
    $name = '';
    if ($hospital_id)
    {
      $hospital = Doctrine::getTable('Hospital')->findOneById($hospital_id);
      
      $name   = $hospital ? $hospital->getName() : '';
    }
    
    return $name;
  }  

  public function getDiagnosises()
  {
  	$diagnosises = $this->getObject()->getDiagnosises();
  	$diagnosis   = $diagnosises->toCustomArray(array('title' => 'getRealName'));
  	return $diagnosis;
  }  
}