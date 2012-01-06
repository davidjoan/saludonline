<?php

/**
 * Specialty form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SpecialtyForm extends BaseSpecialtyForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'code'        => 'Code',
      'name'        => 'Name',
      'description' => 'Description',
      'active'      => 'Active',        
    );
  }    
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                   => new sfWidgetFormInputHidden(),
      'code'                 => new sfWidgetFormInputText(array(), array('size' => 3)),
      'name'                 => new sfWidgetFormInputText(array(), array('size' => 100)),
      'description'          => new sfWidgetFormTextareaTinyMCE(array
                                (
                                  'width'            => 550,
                                  'height'           => 350,
                                  'config'           => 'theme_advanced_disable: "anchor,cleanup,help"',
                                )),
      'active'               => new sfWidgetFormChoice(array
                                (
                                  'choices'          => $this->getTable()->getStatuss(),
                                  'expanded'         => true,
                                  'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                ))
    ));
       
    
    $this->types = array
    (
      'id'                     => '=',
      'code'                   => 'code',
      'name'                   => 'text',
      'description'            => '=',
      'active'                 => array('combo', array('choices' => array_keys($this->getTable()->getStatuss()))),
      'slug'                   => '-',
      'created_at'             => '-',
      'updated_at'             => '-'
    );
  }
}
