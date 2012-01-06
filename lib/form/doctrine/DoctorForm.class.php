<?php

/**
 * Doctor form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DoctorForm extends BaseDoctorForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'specialty_id'   => 'Especialidad',
      'firstname'      => 'Nombres',
      'lastname'       => 'Apellidos',
      'gender'         => 'Genero',
      'email'          => 'Email',
      'office_phone'   => 'Teléfono',
      'mobile_phone'   => 'Celular',
      'fax'            => 'Fax',
      'description'    => 'Descripción',
      'hospitals_list' => 'Hospitales'
    );
  }       
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                       => new sfWidgetFormInputHidden(),             
      'specialty_id'                => new sfWidgetFormDoctrineChoice(array(
                                    'model'   => 'Specialty',
                                    'add_empty' => '---Seleccionar---'
                                    )),
      'firstname'                => new sfWidgetFormInputText(array(), array('size' => 50)),
      'lastname'                 => new sfWidgetFormInputText(array(), array('size' => 50)),
      'gender'                   => new sfWidgetFormChoice(array
                                    (
                                      'choices'          => $this->getTable()->getGenders(),
                                      'expanded'         => true,
                                      'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                    )),          
      'email'                    => new sfWidgetFormInputText(array(), array('size' => 40)),
      'mobile_phone'             => new sfWidgetFormInputText(array(), array('size' => 20)),
      'office_phone'             => new sfWidgetFormInputText(array(), array('size' => 20)),
      'fax'                      => new sfWidgetFormInputText(array(), array('size' => 20)),
      'description'              => new sfWidgetFormTextareaTinyMCE(array
                                    (
                                      'width'            => 350,
                                      'height'           => 150,
                                      'config'           => 'theme_advanced_buttons2 : ""',
                                    )),  
      'hospitals_list'        => new sfWidgetFormJQueryCompleterDoubleList(array
                                (
                                  'selected'  => $this->getHospitals(),
                                 'search_url' => $this->genUrl('@doctor_load_hospital'),
                                 'label_selected' => 'Seleccionados',
                                 'label_autocompleter' => 'Buscar',
                                 'search_config'          => sprintf('{ max: "20" }')
                                )),       
    )); 
    
    $this->setDefault('gender', DoctorTable::GENDER_MALE);
    $this->types = array
    (
      'id'             => '=',
      'specialty_id'   => 'combo',
      'firstname'      => 'text',
      'lastname'       => 'text',
      'gender'         => array('combo', array('choices' => array_keys($this->getTable()->getGenders()))),
      'email'          => 'email',
      'username'       => '-',
      'password'       => '-',
      'home_phone'     => '-',
      'office_phone'   => 'phone',
      'mobile_phone'   => 'phone',
      'fax'            => 'phone',
      'description'    => '=',
      'prefix'         => '-',
      'active'         => '-',
      'slug'           => '-',
      'created_at'     => '-',
      'updated_at'     => '-',
      'patients_list'  => '-',
      'hospitals_list' => 'list'  
    );  
    
    $this->widgetSchema->setFormFormatterName('frontend');    
  }
  
  public function getHospitals()
  {
  	$hospitals = $this->getObject()->getHospitals();
  	$hospital = $hospitals->toCustomArray(array('title' => 'getName'));
  	return $hospital;
  }  
}
