<?php

/**
 * Company form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyForm extends BaseCompanyForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'name'         => 'Name',
      'description'  => 'Description',
      'address'      => 'Address',
      'phones'       => 'Phones',
      'fax'          => 'Fax',
      'mobile_phone' => 'Mobile Phone',
      'mail'         => 'Mail',
      'box'          => 'Box',
      'image'        => 'Logo',
      'message'      => 'Message',
      'active'       => 'Active'
    );
      
  }    
    

  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                   => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(array(), array('size' => 15)),
      'description'          => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5)),
      'address'              => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5)),
      'image'                => new sfWidgetFormInputFileEditable
                                (
                                  array
                                  (
                                    'file_src'     => $this->object->getImage(),
                                    'with_delete'  => false,
                                    'template'     => sprintf
                                                      (
                                                        '<a class="file_link" href="%s/%%file%%" target="BLANK">%%file%%</a><br />%%input%%<br />%%delete%% %%delete_label%%', 
                                                        sfConfig::get('app_company_path')
                                                      )
                                  ),
                                  array('size'         => '60')
                                ),
      'phones'               => new sfWidgetFormInputText(array(), array('size' => 15)),
      'fax'                  => new sfWidgetFormInputText(array(), array('size' => 15)),
      'mobile_phone'         => new sfWidgetFormInputText(array(), array('size' => 15)),
      'mail'                 => new sfWidgetFormInputText(array(), array('size' => 30)),
      'box'                  => new sfWidgetFormInputText(array(), array('size' => 30)),
      'message'              => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5)),
      'active'               => new sfWidgetFormChoice(array
                                (
                                  'choices'          => $this->getTable()->getStatuss(),
                                  'expanded'         => true,
                                  'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                ))
    ));   
    
$this->addValidators(array
    (
      'image'                 => new sfValidatorFile(array
                                (
                                  'required' => false,
                                  'path'     => sfConfig::get('app_company_dir').'/'
                                )),
    ));    
    
    $this->types = array
    (
      'id'           => '=',
      'description'  => 'name',
      'description'  => 'text',
      'address'      => 'text',
      'image'        => 'file',
      'phones'       => 'phone',
      'fax'          => 'phone',
      'mobile_phone' => 'phone',
      'mail'         => 'email',
      'box'          => 'text',
      'message'      => '=',
      'active'       => array('combo', array('choices' => array_keys($this->getTable()->getStatuss()))),
      'created_at'   => '-',
      'updated_at'   => '-',
      'slug'         => '-'
    );    
  }
}
