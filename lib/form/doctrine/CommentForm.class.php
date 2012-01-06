<?php

/**
 * Comment form.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentForm extends BaseCommentForm
{
  public function initialize()
  {
    $this->labels = array
    (
      'author_name'              => 'Nombre',
      'author_email'             => 'E-mail',
      'author_url'               => 'Sitio Web',
      'author_twitter_username'  => 'Twitter',
      'content'                  => 'Contenido',
    );
    
    $this->setOption('required_labels', false);
  }
  
  public function configure()
  {
    $this->setWidgets(array
    (
      'id'                       => new sfWidgetFormInputHidden(),
      'author_name'              => new sfWidgetFormInputText(array(), array('size' => 50)),
      'author_email'             => new sfWidgetFormInputText(array(), array('size' => 50)),
      'author_url'               => new sfWidgetFormInputText(array(), array('size' => 50)),
      'author_twitter_username'  => new sfWidgetFormInputText(array(), array('size' => 50)),
      'content'                  => new sfWidgetFormTextarea(array(), array('rows' => 10, 'cols' => 50)),
    ));
    
    $this->types = array
    (
      'id'                       => '=',
      'post_id'                  => '=',
      'user_id'                  => '-',
      'author_name'              => 'text',
      'author_email'             => 'email',
      'author_url'               => 'url',
      'author_twitter_username'  => 'text',
      'author_ip'                => '=',
      'content'                  => 'text',
      'datetime'                 => '-',
      'agent'                    => '=',
      'approved'                 => '=',
      'slug'                     => '-',
      'created_at'               => '-',
      'updated_at'               => '-',
    );
    
    $this->widgetSchema->setFormFormatterName('frontend');
  }
}
