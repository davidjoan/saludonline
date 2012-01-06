<?php

/**
 * sfFormFieldSchemaExt represents an array of widgets bind to names and values.
 * 
 * Every method from sfFormFieldExt should be copied here, because this class does not inherit from it.
 * If too many methods are copied a workaround with magic method __call (generating a temporal 
 * sfFormFielExt object) should be implemented.
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfFormFieldSchemaExt extends sfFormFieldSchema
{
  /**
   * Returns the form field associated with the name (implements the ArrayAccess interface).
   * 
   * Method overwritten to successfully use sfFormFieldSchemaExt and sfFormFieldExt.
   *
   * @see sfFormFieldSchema
   */
  public function offsetGet($name)
  {
    if (!isset($this->fields[$name]))
    {
      if (null === $widget = $this->widget[$name])
      {
        throw new InvalidArgumentException(sprintf('Widget "%s" does not exist.', $name));
      }

      $error = isset($this->error[$name]) ? $this->error[$name] : null;

      if ($widget instanceof sfWidgetFormSchema)
      {
        $class = 'sfFormFieldSchemaExt';

        if ($error && !$error instanceof sfValidatorErrorSchema)
        {
          $error = new sfValidatorErrorSchema($error->getValidator(), array($error));
        }
      }
      else
      {
        $class = 'sfFormFieldExt';
      }

      $this->fields[$name] = new $class($widget, $this, $name, isset($this->value[$name]) ? $this->value[$name] : null, $error);
    }

    return $this->fields[$name];
  }
  
  /**
   * Returns a formatted row.
   * 
   * @see sfFormFieldExt
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
