<?php

/**
 * sfWidgetFormJavascript represents some javascript to display.
 * 
 * This widget has a required options "js", which is 
 * the javascript to display when rendered.
 *
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormJavascript extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('js');
    $this->addOption('include'  , array());
    $this->setOption('is_hidden', true);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return javascript_tag($this->getOption('js'));
  }
  
  public function getJavascripts()
  {
    return $this->getOption('include');
  }
}
