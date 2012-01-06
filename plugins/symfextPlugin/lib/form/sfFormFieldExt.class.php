<?php

/**
 * sfFormFieldExt represents a widget bind to a name and a value.
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfFormFieldExt extends sfFormField
{
  /**
   * Returns a formatted row.
   *
   * Method overwritten to successfully use formatEmbeddedRow and formatRowExtended methods.
   * 
   * @see sfFormField
   */
  public function renderRow($attributes = array(), $label = null, $help = null)
  {
    if (null === $this->parent)
    {
      throw new LogicException(sprintf('Unable to render the row for "%s".', $this->name));
    }

    $field = $this->parent->getWidget()->renderField($this->name, $this->value, !is_array($attributes) ? array() : $attributes, $this->error);

    $error = $this->error instanceof sfValidatorErrorSchema ? $this->error->getGlobalErrors() : $this->error;

    $help = null === $help ? $this->parent->getWidget()->getHelp($this->name) : $help;
    
    $row  =  $this->parent->getWidget() instanceof sfWidgetFormSchema ? $this->parent->getWidget()->getFormFormatter()->formatEmbeddedRow($this->renderLabel($label), $field, $error, $help) : $this->parent->getWidget()->getFormFormatter()->formatRowExtended($this->renderLabel($label), $field, $error, $help);
    
    return strtr($row, array('%hidden_fields%' => ''));
  }
}
