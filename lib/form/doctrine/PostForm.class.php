<?php

/**
 * Post form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PostForm extends BasePostForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'title'                => 'Title',
      'content'              => 'Content',
      'meta_description'     => 'Meta Description',
      'meta_keywords'        => 'Meta Keywords',
      'status'               => 'Status',
      'image'                => 'Imagen',
      'categories_list'      => 'Categories',
    );
  }
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                   => new sfWidgetFormInputHidden(),
      'title'                => new sfWidgetFormInputText(array(), array('size' => 100)),
      'content'              => new sfWidgetFormTextareaTinyMCE(array
                                (
                                  'width'            => 550,
                                  'height'           => 350,
                                  'config'           => 'theme_advanced_disable: "anchor,cleanup,help"',
                                )),
      'image'                 => new sfWidgetFormInputFileEditable
                                (
                                  array
                                  (
                                    'file_src'     => $this->object->getImage(),
                                    'with_delete'  => false,
                                    'template'     => sprintf
                                                      (
                                                        '<a class="file_link" href="%s/%%file%%" target="BLANK">%%file%%</a><br />%%input%%<br />%%delete%% %%delete_label%%', 
                                                        sfConfig::get('app_post_path')
                                                      )
                                  ),
                                  array('size'         => '60',)
                                ),        
      'meta_description'     => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 5)),
      'meta_keywords'        => new sfWidgetFormTextarea(array(), array('cols' => 50, 'rows' => 2)),
      'status'               => new sfWidgetFormChoice(array
                                (
                                  'choices'          => $this->getTable()->getStatuss(),
                                  'expanded'         => true,
                                  'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                )),
      'categories_list'      => new sfWidgetFormDoctrineChoice(array
                                (
                                  'model'            => $this->getRelatedModelName('Categories'),
                                  'expanded'         => true,
                                  'multiple'         => true,
                                  'renderer_options' => array('formatter' => array($this->widgetFormatter, 'radioFormatter'))
                                )),
    ));
    
    $this->addValidators(array
    (
      'image'                 => new sfValidatorFile(array
                                (
                                  'required'   => false,
                                  'path'       => sfConfig::get('app_post_dir').'/'
                                )),
    ));    
    
    $this->types = array
    (
      'id'                     => '=',
      'user_id'                => '-',
      'title'                  => 'text',
      'image'                  => 'file',
      'content'                => '=',
      'meta_description'       => '=',
      'meta_keywords'          => '=',
      'excerpt'                => '-',
      'datetime'               => '-',
      'status'                 => array('combo', array('choices' => array_keys($this->getTable()->getStatuss()))),
      'slug'                   => '-',
      'created_at'             => '-',
      'updated_at'             => '-',
      'categories_list'        => 'list',
    );
  }
  
  protected function updateTitleColumn($title)
  {    
    $this->object->getPostIndex()->setTitle($title);
    
    return $title;
  }
  
  protected function updateContentColumn($content)
  {
   // $index_content = preg_replace_callback('#< pre>\[(\w+)\](.*?)\[/\\1\]< /pre>#s', array($this, 'processCode'), $content);

    $index_content = preg_replace_callback('#\[(\w+)\](.*?)\[/\\1\]#s', array($this, 'processCode'), $content);
  
 
    $this->object->getPostIndex()->setContent($index_content);
 
    return $content;
  }
 
  protected function processCode($matches)
  {
    $code = str_replace('& nbsp;', ' ', $matches[2]);
    $code = html_entity_decode($code);
 
    $geshi = new GeSHi($code, $matches[1]);
    $geshi->set_header_type(GESHI_HEADER_PRE);
    $geshi->enable_classes();
 
    return $geshi->parse_code();
  }
}
