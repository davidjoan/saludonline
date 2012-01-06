<?php

/**
 * Resource form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceForm extends BaseResourceForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'name'                 => 'Nombre',
      'path'                 => 'Documento',
    );
  }
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInput(array(), array('size' => '30')),
      'path'                 => new sfWidgetFormInputFileEditable
                                (
                                  array
                                  (
                                    'file_src'     => $this->object->getPath(),
                                    'with_delete'  => false,
                                    'template'     => sprintf
                                                      (
                                                        '<a class="file_link" href="%s/%%file%%" target="BLANK">%%file%%</a><br />%%input%%<br />%%delete%% %%delete_label%%', 
                                                        sfConfig::get('app_resource_path')
                                                      )
                                  ),
                                  array('size'         => '60',)
                                ),
    ));
    
    $this->addValidators(array
    (
      'path'                 => new sfValidatorFile(array
                                (
                                  'required'   => false,
                                  'path'       => sfConfig::get('app_resource_dir').'/'
                                )),
    ));
    
    $this->types = array
    (
      'id'                      => '=',
      'name'                    => 'text',
      'path'                    => 'file',
      'size'                    => '-',
      'full_mime'               => '-',
      'rank'                    => '-',
      'slug'                    => '-',
      'created_at'              => '-',
      'updated_at'              => '-'
    );
    
    $this->widgetSchema->setFormFormatterName('frontend');      
  }
}
