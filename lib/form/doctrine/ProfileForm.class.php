<?php

/**
 * Profile form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProfileForm extends BaseProfileForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'dni'            => 'DNI',
      'firstname'      => 'Nombres',
      'lastname'       => 'Apellidos',
      'date_of_birth'  => 'Fecha de Nacimiento',
      'gender'         => 'Genero',
      'image'          => 'Foto',
      'description'    => 'Descripción',
      'blood_type'     => 'Tipo de Sangre',
      'type'           => 'Parentesco',
      'marital_status' => 'Estado Civil'
    );
  }    
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                       => new sfWidgetFormInputHidden(),
      'dni'                      => new sfWidgetFormInputText(array(), array('size' => 8, 'maxlength' => 8)),
      'firstname'                => new sfWidgetFormInputText(array(), array('size' => 50)),
      'lastname'                 => new sfWidgetFormInputText(array(), array('size' => 50)),
      'date_of_birth'            => new sfWidgetFormDateExt(array
                                (
                                  'format'     => $this->widgetFormatter->getStandardDateFormat(),
                                  'year_start' => 1920,
                                  'year_end'   => date('Y') - 5,
                                )),        
      'gender'                   => new sfWidgetFormChoice(array
                                    (
                                      'choices'          => $this->getTable()->getGenders(),
                                      'expanded'         => true,
                                      'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                    )),        
      'image'                    => new sfWidgetFormInputFileEditable
                                    (
                                      array
                                      (
                                        'file_src'     => $this->object->getImage(),
                                        'with_delete'  => false,
                                        'template'     => sprintf
                                                          (
                                                            '<a class="file_link" href="%s/%%file%%" target="BLANK">%%file%%</a><br />%%input%%<br />%%delete%% %%delete_label%%', 
                                                            sfConfig::get('app_profile_path')
                                                          )
                                      ),
                                      array('size'         => '60')
                                    ),         
      'description'              => new sfWidgetFormTextareaTinyMCE(array
                                    (
                                      'width'            => 350,
                                      'height'           => 150,
                                      'config'           => 'theme_advanced_buttons2 : ""',
                                    )),
      'blood_type'               => new sfWidgetFormChoice(array
                                    (
                                      'choices'          => $this->getTable()->getBloodTypes(),
                                      'expanded'         => false
                                    )),
      'type'                     => new sfWidgetFormChoice(array
                                    (
                                      'choices'          => $this->getTable()->getTypes(),
                                      'expanded'         => true,
                                      'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                    )),

      'marital_status'               => new sfWidgetFormChoice(array
                                    (
                                      'choices'          => $this->getTable()->getMaritalStatuss(),
                                      'expanded'         => true,
                                      'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                    )),         
    ));      

    $this->addValidators(array
    (
      'image'                 => new sfValidatorFile(array
                                (
                                  'required'   => false,
                                  'path'       => sfConfig::get('app_profile_dir').'/'
                                )),
      'dni'            => new sfValidatorString(array('max_length' => 8, 'min_length' => 8)),
    ));

    $this->setDefault('gender', ProfileTable::GENDER_MALE);

    $this->types = array
    (
      'id'             => '=',
      'dni'            => 'fixed_number',
      'firstname'      => 'text',
      'lastname'       => 'text',
      'date_of_birth'  => 'date',
      'gender'         => array('combo', array('choices' => array_keys($this->getTable()->getGenders()))),
      'image'          => 'file',
      'description'    => '=',
      'blood_type'     => array('combo', array('choices' => array_keys($this->getTable()->getBloodTypes()))),
      'type'           => array('combo', array('choices' => array_keys($this->getTable()->getTypes()))),
      'marital_status' => array('combo', array('choices' => array_keys($this->getTable()->getMaritalStatuss()))),
      'active'         => '-',
      'slug'           => '-',
      'created_at'     => '-',
      'updated_at'     => '-',
      'patients_list'  => '-'
    );    
    

    $this->widgetSchema->setFormFormatterName('frontend');
    
  }
}
