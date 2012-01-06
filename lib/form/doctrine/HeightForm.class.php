<?php

/**
 * Height form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HeightForm extends BaseHeightForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'current_height'  => 'Talla (Cm.)',
      'date_of_height'  => 'Fecha',
      'description'     => 'Notas'
    );
  }      
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                       => new sfWidgetFormInputHidden(),
      'current_height'           => new sfWidgetFormInputText(array(), array('size' => 10)),
      'date_of_height'           => new sfWidgetFormDateExt(array
                                (
                                  'format'     => $this->widgetFormatter->getStandardDateFormat(),
                                  'year_start' => 1920,
                                  'year_end'   => date('Y'),
                                )),        
              
      'description'              => new sfWidgetFormTextareaTinyMCE(array
                                    (
                                      'width'            => 350,
                                      'height'           => 150,
                                      'config'           => 'theme_advanced_buttons2 : ""',
                                    )),
    ));           

    $this->types = array
    (
      'id'              => '=',
      'profile_id'      => '-',
      'current_height'  => 'float',
      'date_of_height'  => 'date',
      'description'     => '=',
      'active'          => '-',
      'created_at'      => '-',
      'updated_at'      => '-',    
    );    
    $this->validatorSchema['current_height']->setOption('required' , true);
    $this->validatorSchema['date_of_height']->setOption('required' , true);
    
    $this->setDefault('date_of_height', date('Y-m-d'));

    $this->widgetSchema->setFormFormatterName('frontend');
  }
}
