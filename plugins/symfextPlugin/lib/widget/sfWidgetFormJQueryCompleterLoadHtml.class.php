<?php

/**
 * sfWidgetFormJQueryCompleterLoadHtml
 * 
 * Represents an autocompleter but with a custom html.
 * 
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormJQueryCompleterLoadHtml extends sfWidgetFormJQueryCompleter
{
  /**
   * Configures the widget.
   * 
   * Available options:
   *
   *  * div_id:        The id of the div (required)
   * 
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormJQueryCompleter
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('div_id');
    
    parent::configure($options, $attributes);
    
    $this->setOption('select_callback', 'function (options, input, selectCurrent, config) { return sfWidgetFormJQueryCompleterLoadHtml(options, input, selectCurrent, config, "'.$options['div_id'].'"); }');
    $this->setOption('parse_callback' , 'function (data) { return data; }');
  }
  
  /**
   * @see sfWidget
   */
  public function getJavascripts()
  {
    return array_merge(array('/js/widget/sfWidgetFormJQueryCompleterLoadHtml.js'), parent::getJavascripts());
  }
}
