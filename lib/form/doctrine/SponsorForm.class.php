<?php

/**
 * Sponsor form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SponsorForm extends BaseSponsorForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'name'                => 'Name',
      'url'                 => 'Url',
      'description'         => 'Description'
    );
  }  
  
  public function configure()
  {
  $this->setWidgets(array
    (
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(array(), array('size' => 60)),
      'url'                  => new sfWidgetFormInputText(array(), array('size' => 60)),
      'description'          => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5))
   
    ));
    
    $this->types = array
    (
      'id'                     => '=',
      'name'                   => 'text',
      'url'                    => 'url',
      'description'            => '=',
      'slug'                   => '-',
      'created_at'             => '-',
      'updated_at'             => '-'
    );      
  }
}
