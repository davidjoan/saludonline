<?php

/**
 * sfWidgetFormJQueryCompleter
 * 
 * Represents the base of any autocompleter.
 * 
 * By default it has the autocompleter functionality.
 * 
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormJQueryCompleter extends sfWidgetFormInputText
{
  /**
   * Configures the widget.
   * 
   * Available options:
   *
   *  * url:             The target url to retrieve data (required)
   *  * value_callback:  A callback to use to get the visible value for the widget
   *  * select_callback: A javascript callback used to get the select javascript object
   *  * parse_callback:  A javascript callback to parsed the upcoming data
   *  * format_item:     A javascript callback to format the data before showing it
   *  * on_select_call:  A javascript function to call when the user selects any of the options
   *  * config:          A json array of configuration variables
   *  * loading_image:   The image to show when retrieving the data
   * 
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInputText
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url');
    $this->addOption('value_callback');
    $this->addOption('select_callback', '""');
    $this->addOption('parse_callback' , 'function(data)
                                         {
                                           var parsed = [];
                                           for (key in data)
                                           {
                                             parsed[parsed.length] = { data: data[key], id: data[key].id, title: data[key].title, content: data[key].content };
                                           }
                                           
                                           return parsed;
                                         }');
    $this->addOption('format_item'    , 'function(data) { return data.title; }');
    $this->addOption('on_select_call' , '');
    $this->addOption('config'         , '{ }');
    $this->addOption('loading_image'  , sfConfig::get('sf_images_path').'/general/snake.gif');
    
    parent::configure($options, $attributes);
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
   * @see sfWidgetFormInput
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $visibleValue = $this->getOption('value_callback') ? call_user_func($this->getOption('value_callback'), $value) : $value;
    
    return $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => $value, 'disabled' => false)).
           parent::render('autocomplete_'.$name, $visibleValue, $attributes, $errors).
           //$this->renderContentTag('img', null, array('src' => $this->getOption('loading_image'), 'name' => 'loading_image_'.$name, 'style' => 'display: none;')).
           sprintf
           (
             <<<EOF
               <script type="text/javascript">
                 $(document).ready(function()
                 {
                   $("#%s").autocomplete("%s", $.extend({}, 
                   {
                     id             : "%s",   
                     dataType       : "json",
                     selectCallback : %s,
                     formatItem     : %s,
                     parse          : %s,
                   }, %s))
                   .keyup(function ()
                   {
                     if ($(this).val() == "")
                     {
                       $("#%s").val("");
                     }
                   })
                   .result(function (event, data)
                   {
                     var id = "%s";
                   
                     $("#%s").val(data.id);
                     $("#%s").val(data.title);
                     %s
                   });
                 })
               </script>
EOF
             ,
             $this->generateId('autocomplete_'.$name),
             $this->getOption('url'),
             $this->generateId($name),
             $this->getOption('select_callback'),
             $this->getOption('format_item'),
             $this->getOption('parse_callback'),
             $this->getOption('config'),
             $this->generateId($name),
             $this->generateId($name),
             $this->generateId($name),
             $this->generateId('autocomplete_'.$name),
             $this->getOption('on_select_call')
           );
  }
  
  /**
   * @see sfWidget
   */
  public function getStylesheets()
  {
    return array('/css/jquery/autocompleter.css' => 'screen');
  }
  
  /**
   * @see sfWidget
   */
  public function getJavascripts()
  {
    return array('/js/widget/sfWidgetFormJQueryCompleter.js');
  }
}
