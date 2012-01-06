<?php

/**
 * sfWidgetFormJQueryDependantAutocompleter
 * 
 * Similar to sfWidgetFormJQueryAutocompleter but its query list
 * depends on the value of another widget.
 * 
 * How to use it:
 * [code]
 * 
 * 'page_id'    => new sfWidgetFormJQueryDependantAutocompleter(array
 *                 (
 *                   'url'    => $this->genUrl('@page_load_main_pages'),
 *                   'widget' => $this->generateLazyId('page_title'),
 *                   'config' => sprintf('{ base: "%s", max: "20" }', $this->generateLazyId('category_id'))
 *                 )),
 * 'page_title' => new sfWidgetFormInputText(array(), array('size' => 42)),
 * 
 * [/code]
 * 
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormJQueryDependantAutocompleter extends sfWidgetFormInputHidden
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url');
    $this->addRequiredOption('widget');
    $this->addOption('config', '{}');
    
    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => $value)).
           sprintf
           (
             <<<EOF
               <script type="text/javascript">
                 $("#%s").autocomplete("%s", $.extend
                 (
                   {},
                   {
                     dataType  : "json",
                     formatItem: function(data)
                                 {
                                   return data.content;
                                 },
                     parse     : function(data)
                                 {
                                   var parsed = [];
                                   for (key in data)
                                   {
                                     parsed[parsed.length] = { data: data[key], value: data[key].title, result: data[key].title };
                                   }
                                   
                                   return parsed;
                                 }
                   },
                   %s
                 )).result(function(event, data)
                 {
                   $("#%s").val(data.id);
                 });
               </script>
EOF
             ,
             $this->getOption('widget'),
             $this->getOption('url'),
             $this->getOption('config'),
             $this->generateId($name)
           );
  }
  
  public function getStylesheets()
  {
    return array('/css/jquery/autocompleter' => 'all');
  }
  
  public function getJavascripts()
  {
    return array('/js/widget/sfWidgetFormJQueryDependantAutocompleter.js');
  }
}
