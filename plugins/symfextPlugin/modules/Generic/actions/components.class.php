<?php

/**
 * Generic components.
 *
 * @package    symfext
 * @subpackage Generic
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class GenericComponents extends ComponentsProject
{
  /**
   * Configures the variables to use in the component form.
   */
  public function executeForm()
  {
    $this->action_url          = $this->getController()->genUrl($this->action_uri);
    $this->autocomplete        = isset($this->autocomplete)  ? $this->autocomplete : 'on';
    $this->styles_folder       = isset($this->styles_folder) ? $this->styles_folder : 'modules';
    $this->styles              = sprintf('%s/%s/form.css', sfConfig::get('sf_app'), $this->styles_folder);
    $this->with_title          = isset($this->with_title)    ? $this->with_title    : true;
  }
  public function executeFormulario()
  {
    $this->action_url          = $this->getController()->genUrl($this->action_uri);
    $this->autocomplete        = isset($this->autocomplete)  ? $this->autocomplete : 'on';
    $this->styles_folder       = isset($this->styles_folder) ? $this->styles_folder : 'modules';
    $this->styles              = sprintf('%s/%s/form.css', sfConfig::get('sf_app'), $this->styles_folder);
    $this->with_title          = isset($this->with_title)    ? $this->with_title    : true;
    $this->with_back          = isset($this->with_back)    ? $this->with_back    : true;
  }  
}
