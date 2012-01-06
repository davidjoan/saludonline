<?php

/**
 * sfWidgetFormJQueryCompleterDoubleList
 * 
 * Represents a double list widget, being one an autocompleter
 * and the other one a simple div list.
 * 
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormJQueryCompleterDoubleList extends sfWidgetForm
{
  /**
   * Configures the widget.
   * 
   * Available options:
   *
   *  * selected:            The selected items (required)
   *  * search_uri:          The target uri to search the data (required)
   *  * search_config:       A json array of configuration variables for the search
   *  
   *  * class:               The main class of the widget
   *  * class_select:        The class for the two select tags
   *  * label_selected:      The label for selected
   *  * label_autocompleter: The label for the search widget
   *  * associate:           The HTML for the associate link
   *  * disassociate:        The HTML for the unassociate link
   *  * template:            The HTML template to use to render this widget
   *                         The available placeholders are:
   *                           * class
   *                           * label_autocompleter
   *                           * autocompleter
   *                           * associate
   *                           * label_selected
   *                           * associated
   *                           * field
   *                           * disassociate
   *                           * id
   *                           * class_select
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('selected');
    $this->addRequiredOption('search_url');
    $this->addOption('search_config', '{ }');

    $this->addOption('class'              , 'autocompleter_list');
    $this->addOption('class_select'       , 'autocompleter_list_select');
    $this->addOption('label_selected'     , 'Selected');
    $this->addOption('label_autocompleter', 'Search');
    $this->addOption('associate'          , sprintf('<img src="%s/general/icons/add.png" alt="associate" />'      , sfConfig::get('sf_images_path')));
    $this->addOption('disassociate'       , sprintf('<img src="%s/general/icons/delete.png" alt="unassociate" />'  , sfConfig::get('sf_images_path')));
    $this->addOption('template', 
      <<<EOF
        <div class="%class%">
          <div style="float: left">
            <div class="autocompleter_list_label">%label_autocompleter%</div>
            %autocompleter%
          </div>
          <div style="float: left; margin-top: 2em;margin-left:0.7em">
            <br/><br/>
            %associate%
          </div>
          <div style="float: right;margin-top: 3.3em">
            <div class="autocompleter_list_label">%label_selected%</div>
            %associated%
            %field%
          </div>
          <div style="float: left; margin-top: 2em;margin-left:0.7em">
            %disassociate%
          </div>
          <br style="clear: both" />
          <script type="text/javascript">
            sfWidgetFormJQueryCompleterDoubleList.init("%id%", "%class_select%");
          </script>
        </div>
EOF
    );
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
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (is_null($value))
    {
      $value = array();
    }

    $selected = $this->getOption('selected');
    if ($selected instanceof sfCallable)
    {
      $selected = $selected->call();
    }

    $hiddenSelect     = new sfWidgetFormSelect(array('multiple' => true, 'choices' => $selected), array('style' => 'display: none;'));
    $searchWidget     = new sfWidgetFormJQueryCompleterList(array
                        (
                          'url'    => $this->getOption('search_url'),
                          'config' => $this->getOption('search_config')
                        ));
    
    $id = $this->generateId($name);
    
    return strtr($this->getOption('template'), array(
      '%class%'               => $this->getOption('class'),
      '%class_select%'        => $this->getOption('class_select'),
      '%id%'                  => $id,
      '%label_selected%'      => $this->getOption('label_selected'),
      '%label_autocompleter%' => $this->getOption('label_autocompleter'),
      '%associate%'           => sprintf('<a href="#" onclick="%s" rel="page_edit">%s</a>', 'sfWidgetFormJQueryCompleterDoubleList.associate(\''.$id.'\'); return false;', $this->getOption('associate')),
      '%disassociate%'        => sprintf('<a href="#" onclick="%s" rel="page_edit">%s</a>', 'sfWidgetFormJQueryCompleterDoubleList.disassociate(\''.$id.'\'); return false;', $this->getOption('disassociate')),
      '%associated%'          => sprintf('<div id="%s_associated_div" class="sfWidgetFormJQueryCompleterList"></div>', $id),
      '%field%'               => $hiddenSelect->render($name),
      '%autocompleter%'       => $searchWidget->render($name.'_search'),
    ));
  }

  /**
   * @see sfWidget
   */
  public function getStylesheets()
  {
    return array_merge(array('/css/widget/sfWidgetFormJQueryCompleterDoubleList.css' => 'screen', '/css/widget/sfWidgetFormJQueryCompleterList.css' => 'screen'), parent::getStylesheets());
  }
  
  /**
   * @see sfWidget
   */
  public function getJavascripts()
  {
    return array('/js/widget/sfWidgetFormJQueryCompleterDoubleList.js', '/js/widget/sfWidgetFormJQueryCompleterList.js', '/js/widget/sfWidgetFormJQueryCompleter.js');
  }
  
  /**
   * Clones this object
   */
  public function __clone()
  {
    if ($this->getOption('selected') instanceof sfCallable)
    {
      $callable = $this->getOption('selected')->getCallable();
      if (is_array($callable))
      {
        $callable[0] = $this;
        $this->setOption('selected', new sfCallable($callable));
      }
    }
  }
}
