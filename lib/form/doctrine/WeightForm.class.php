<?php

/**
 * Weight form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class WeightForm extends BaseWeightForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'current_weight'  => 'Peso (Kg.)',
   //   'expected_weight' => 'Peso Esperado',
      'date_of_weight'  => 'Fecha',
      'description'     => 'Notas'
    );
  }
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                       => new sfWidgetFormInputHidden(),
     // 'profile_id'               => new sfWidgetFormValue(array('value' => $this->getObject()->getProfile()->getFullname())),
      'current_weight'           => new sfWidgetFormInputText(array(), array('size' => 10)),
      /*'expected_weight'          => new sfWidgetFormInputText(array(), array('size' => 10)),*/
      'date_of_weight'           => new sfWidgetFormDateExt(array
                                (
                                  'format'     => $this->widgetFormatter->getStandardDateFormat(),
                                  'year_start' => 1920,
                                  'year_end'   => date('Y'),
                                )),        
    /*           
      'description'              => new sfWidgetFormTextareaTinyMCE(array
                                    (
                                      'width'            => 350,
                                      'height'           => 150,
                                      'config'           => 'theme_advanced_buttons2 : ""',
                                    )),    */  
    ));           

    $this->types = array
    (
      'id'              => '=',
      'profile_id'      => '-',
      'current_weight'  => 'float',
      'expected_weight' => '-',
      'date_of_weight'  => 'date',
      'description'     => '-',
      'active'          => '-',
      'created_at'      => '-',
      'updated_at'      => '-',    
    );    
    $this->validatorSchema['current_weight']->setOption('required' , true);
  //  $this->validatorSchema['expected_weight']->setOption('required', true);
    $this->validatorSchema['date_of_weight']->setOption('required' , true);
    
    $this->setDefault('date_of_weight', date('Y-m-d'));

    $this->widgetSchema->setFormFormatterName('frontend');
  }
}
