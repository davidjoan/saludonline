<?php

/**
 * sfDoctrineTemplateExt
 *
 * @package    symfext
 * @subpackage doctrine
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
abstract class sfDoctrineTemplateExt
{
  protected
    $object = null;
    
  public function __construct(DoctrineRecord $object)
  {
    $this->object = $object;
  }
  
  /**
   * Renders a HTML content tag.
   *
   * @param string $tag         The tag name
   * @param string $content     The content of the tag
   *
   * @param string An HTML tag string
   */
  public function renderContentTag($tag, $content)
  {
    if (empty($tag))
    {
      return '';
    }
    
    return sprintf('<%s>%s</%s>', $tag, $content, $tag);
  }
  
  public function __call($method, $arguments)
  {
    return call_user_func_array(array($this->object, $method), $arguments);
  }
}
