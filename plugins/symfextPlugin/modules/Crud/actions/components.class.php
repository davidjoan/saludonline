<?php

/**
 * Crud components.
 *
 * @package    symfext
 * @subpackage Crud
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class CrudComponents extends ComponentsProject
{
  /**
   * Configures the variables to use in the component list.
   * 
   * options for variable "params":
   *  
   * filter    : if the field is needed to be filtered
   * id        : identifier
   * list      : if the field is a list of values (e.g. slug)
   * single    : the field accepts just one option to be chosen
   * to_delete : if should be shown a delete confirmation
   * validate  : if the field should be validated (if at least one option should be chosen)
   * value     : the value of the field
   */
  public function executeList()
  {
    $this->usClass             = $this->getRequestParameter('usClass');
    $this->modelClass          = $this->getRequestParameter('modelClass');
    $this->tableClass          = $this->getRequestParameter('tableClass');
    $this->formClass           = $this->getRequestParameter('formClass');
    $this->namespace           = $this->getRequestParameter('namespace');
    
    $this->object              = isset($this->object)             ? $this->object                                   : null;
    
    $buttons                   = array
                                 (
                                   'add'    => true,
                                   'edit'   => true,
                                   'delete' => true
                                 );
    $this->buttons             = array_merge($buttons, isset($this->buttons) ? $this->buttons                       : array());
    $this->edit_field          = isset($this->edit_field)         ? $this->edit_field                               : 'name';
    $this->edit_field_content  = isset($this->edit_field_content) ? $this->edit_field_content                       : 'text';
    $this->edit_uri            = isset($this->edit_uri)           ? $this->edit_uri                                 : '@%s_edit';
    
    $params                    = array
                                 (
                                   'filter_by' => array('id' => 'filter_by'                  ),
                                   'filter'    => array('id' => 'filter'   , 'filter' => true),
                                   'order_by'  => array('id' => 'order_by'                   ),
                                   'order'     => array('id' => 'order'                      ),
                                   'max'       => array('id' => 'max'                        ),
                                   'page'      => array('id' => 'page'                       ),
                                 );
    $this->params              = isset($this->params)             ? array_merge($params, $this->params) : $params;
    
    $this->listColumns         = $this->buildListColumns($this->columns);
    $this->columns_number      = count($this->listColumns);
    $this->sort                = isset($this->sort)               ? $this->sort                                     : false;
    $this->sort_uri            = isset($this->sort_uri)           ? $this->sort_uri                                 : null;
    $this->sort_url            = $this->sort_uri                  ? $this->getController()->genUrl($this->sort_uri) : null;
  }
  protected function buildListColumns(array $columns)
  {
    $listColumns = array();
    foreach ($columns as $properties)
    {
      $listColumns[] = new ListColumn($properties);
    }
    
    return $listColumns;
  }
  
  /**
   * Configures the variables to use in the component edit.
   */
  public function executeEdit()
  {
    $this->usClass             = $this->getRequestParameter('usClass');
    $this->modelClass          = $this->getRequestParameter('modelClass');
    $this->tableClass          = $this->getRequestParameter('tableClass');
    $this->formClass           = $this->getRequestParameter('formClass');
    $this->namespace           = $this->getRequestParameter('namespace');
    
    $this->autocomplete        = isset($this->autocomplete)              ? $this->autocomplete       : 'on';
    $this->object              = method_exists($this->form, 'getObject') ? $this->form->getObject()  : null;
    $this->parent              = isset($this->parent)                    ? $this->parent             : null;
    
    $this->action_uri          = isset($this->action_uri)                ? $this->action_uri         : $this->getCurrentActionUri();
    $this->action_url          = $this->getController()->genUrl($this->action_uri);
  }
  
  protected function getCurrentActionUri()
  {
    $action_uri = '';
    if (isset($this->route))
    {
      $action_uri  = $this->parent ? sprintf('%s?parent_slug=%s', $this->route, $this->parent->getSlug()) : $this->route;
    }
    elseif ($this->object->isNew())
    {
      $action_uri  = sprintf('@%s_new', $this->usClass);
      $action_uri .= $this->parent ? '?parent_slug='.$this->parent->getSlug() : '';
    }
    else
    {
      $action_uri = sprintf('@%s_edit?slug=%s', $this->usClass, $this->object->getSlug());
    }
    
    return $action_uri;
  }
}
