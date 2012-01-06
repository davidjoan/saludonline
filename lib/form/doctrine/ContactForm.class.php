<?php

/**
 * Contact form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactForm extends BaseContactForm
{
 public function initialize()
  {
    $this->labels = array
    (
      'firstname'     => 'Nombres',
      'lastname'      => 'Apellidos',
      'gender'        => 'Genero',
      'email'         => 'Email',
      'home_phone'    => 'Teléfono de Casa',
      'office_phone'  => 'Teléfono de Oficina',
      'mobile_phone'  => 'Celular',
      'rpm'           => 'Rpm',
      'rpc'           => 'Rpc',
      'nextel'        => 'Nextel',
      'fax'           => 'Fax',
      'address_home'  => 'Dirección de Casa',
      'address_work'  => 'Dirección de Oficína',
      'description'   => 'Descripción',
      'prefix'        => 'Tratamiento',
    );
  }    
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                       => new sfWidgetFormInputHidden(),
      'prefix'                   => new sfWidgetFormChoice(array
                                    (
                                      'choices'          => $this->getTable()->getPrefixs(),
                                      'expanded'         => false
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
      'home_phone'               => new sfWidgetFormInputText(array(), array('size' => 20)),
      'office_phone'             => new sfWidgetFormInputText(array(), array('size' => 20)),
      'mobile_phone'             => new sfWidgetFormInputText(array(), array('size' => 20)),
      'rpm'                      => new sfWidgetFormInputText(array(), array('size' => 20)),
      'rpc'                      => new sfWidgetFormInputText(array(), array('size' => 20)),
      'nextel'                   => new sfWidgetFormInputText(array(), array('size' => 20)),
      'fax'                      => new sfWidgetFormInputText(array(), array('size' => 20)),
      'address_home'             => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5)),
      'address_work'             => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5)),
      'description'              => new sfWidgetFormTextareaTinyMCE(array
                                    (
                                      'width'            => 350,
                                      'height'           => 150,
                                      'config'           => 'theme_advanced_buttons2 : ""',
                                    )),                                   
    ));        
    $this->setDefault('gender', ContactTable::GENDER_MALE);
    $this->types = array
    (
      'id'             => '=',
      'firstname'      => 'text',
      'lastname'       => 'text',
      'gender'         => array('combo', array('choices' => array_keys($this->getTable()->getGenders()))),
      'email'          => 'email',
      'home_phone'     => 'phone',
      'office_phone'   => 'phone',
      'mobile_phone'   => 'phone',
      'rpm'            => 'phone',
      'rpc'            => 'phone',
      'nextel'         => 'phone',
      'fax'            => 'phone',
      'address_home'   => 'text',
      'address_work'   => 'text',
      'description'    => '=',
      'prefix'         => array('combo', array('choices' => array_keys($this->getTable()->getPrefixs()))),
      'active'         => '-',
      'slug'           => '-',
      'created_at'     => '-',
      'updated_at'     => '-',
      'patients_list'  => '-'      
    );  
    
    $this->widgetSchema->setFormFormatterName('frontend');
  }
}
