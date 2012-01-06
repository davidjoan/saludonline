<?php

/**
 * Category form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryForm extends BaseCategoryForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'name'                => 'Name'
    );
  }  
  public function configure()
  {
  $this->setWidgets(array
    (
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(array(), array('size' => 60))
    ));  

    $this->types = array
    (
      'id'                     => '=',
      'name'                   => 'text',
      'slug'                   => '-',
      'created_at'             => '-',
      'updated_at'             => '-',
      'posts_list'             => '-'
    ); 
  }
}
