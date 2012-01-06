<?php

/**
 * sfWidgetFormValue represents a value to display.
 * 
 * This widget has a required options "value", which is 
 * the value to display when rendered.
 *
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormValue extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('value');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return $this->getOption('value');
  }
}
