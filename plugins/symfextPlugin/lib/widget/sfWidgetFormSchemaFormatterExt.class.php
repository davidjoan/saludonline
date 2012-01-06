<?php

/**
 * sfWidgetFormSchemaFormatterExt allows to format a form schema with HTML formats.
 *
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormSchemaFormatterExt extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat                 = "<tr>\n  <td class=\"label\">\n  <span %class%>%label%</span>\n</td>\n  <td class=\"field\">\n  %field%%help%%hidden_fields% \n</td>\n</tr>\n",
    $rowEmbeddedFormat         = "<tr>\n  <td colspan=\"100\">\n  %field%%help%%hidden_fields% \n</td>\n</tr>\n",
    $helpFormat                = "<br/>%help%",
    $errorRowFormat            = "<tr>\n  <td class=\"error\" colspan=\"100\">\n  %errors% \n</td>\n</tr>\n",
    $errorListFormatInARow     = "  <ul class=\"error_list\">\n  %errors% \n</ul>\n",
    $namedErrorRowFormatInARow = "<li>%error%</li>\n",
    $decoratorFormat           = "<table class=\"embedded_form\">\n  <tr>\n  <th class=\"title\" colspan=\"100\">\n  %label% \n</th>\n</tr>\n  %content% \n</table>\n";
    
  public function formatRowExtended($label, $field, $errors = array(), $help = '', $hiddenFields = null, $name = null)
  {
    $slot_name = 'crud_slot_'.$name;
    
    return strtr($this->getRowFormat(), array
           (
             '%class%'         => strpos($label, '*') ? 'class="required"' : '',
             '%label%'         => $label,
             '%field%'         => $name !== null && has_slot($slot_name) ? get_slot($slot_name) : $field,
             '%help%'          => $this->formatHelp($help),
             '%hidden_fields%' => null === $hiddenFields ? '%hidden_fields%' : $hiddenFields,
           ));
  }
  public function formatEmbeddedRow($label, $field, $errors = array(), $help = '', $hiddenFields = null, $name = null)
  {
    $slot_name = 'crud_slot_'.$name;
    
    $row = strtr($this->getRowEmbeddedFormat(), array
           (
             '%field%'         => $name !== null && has_slot($slot_name) ? get_slot($slot_name) : $field,
             '%help%'          => $this->formatHelp($help),
             '%hidden_fields%' => null === $hiddenFields ? '%hidden_fields%' : $hiddenFields,
           ));
           
    return str_replace('%label%', $label, $row);
  }
  
  /**
   * Generates a label for the given field name.
   * 
   * It also creates an id attribute for the label.
   *
   * @see sfWidgetFormSchemaFormatter
   */
  public function generateLabel($name, $attributes = array())
  {
    $labelName = $this->generateLabelName($name);

    if (false === $labelName)
    {
      return '';
    }

    if (!isset($attributes['for']))
    {
      $attributes['for'] = $this->widgetSchema->generateId($this->widgetSchema->generateName($name));
    }

    if (!isset($attributes['id']))
    {
      $attributes['id'] = sprintf('label_%s', $attributes['for']);
    }

    return $this->widgetSchema->renderContentTag('label', $labelName, $attributes);
  }
  
  public function setRowEmbeddedFormat($format)
  {
    $this->rowEmbeddedFormat = $format;
  }
  public function getRowEmbeddedFormat()
  {
    return $this->rowEmbeddedFormat;
  }
}
