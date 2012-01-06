<?php

/**
 * sfWidgetFormJQueryCompleterList
 * 
 * Represents an autocompleter but with a div list.
 * 
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormJQueryCompleterList extends sfWidgetFormJQueryCompleter
{
  /**
   * Configures the widget.
   * 
   * Available options:
   *
   *  * show_div:        Whether or not to show the div (required)
   * 
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormJQueryCompleter
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('show_div', true);
    
    parent::configure($options, $attributes);
    
    $this->setOption('select_callback', 'function (options, input, selectCurrent, config) { return sfWidgetFormJQueryCompleterList(options, input, selectCurrent, config); }');
  }
  
  /**
   * Renders the widget.
   * 
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetFormJQueryCompleter
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return parent::render($name, $value, $attributes, $errors).
           $this->renderContentTag('div', null, array('name' => 'list_'.$name, 'class' => 'sfWidgetFormJQueryCompleterList', 'style' => $this->getOption('show_div') ? '' : 'display: none;'));
  }
  
  /**
   * @see sfWidget
   */
  public function getStylesheets()
  {
    return array('/css/widget/sfWidgetFormJQueryCompleterList.css' => 'screen');
  }
  
  /**
   * @see sfWidget
   */
  public function getJavascripts()
  {
    return array_merge(array('/js/widget/sfWidgetFormJQueryCompleterList.js'), parent::getJavascripts());
  }
}
