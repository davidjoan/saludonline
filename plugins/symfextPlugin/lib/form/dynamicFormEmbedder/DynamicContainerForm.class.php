<?php

/**
 * DynamicContainerForm
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class DynamicContainerForm extends BaseForm
{
  public function getFormJavascripts()
  {
    return array('/js/general/sfDynamicFormEmbedder.js');
  }
}
