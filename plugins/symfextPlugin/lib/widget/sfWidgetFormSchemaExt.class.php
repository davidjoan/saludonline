<?php

/**
 * sfWidgetFormSchemaExt represents an array of fields.
 *
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormSchemaExt extends sfWidgetFormSchema
{
  /**
   * Renders the widget.
   *
   * @param string $name       The name of the HTML widget
   * @param mixed  $values     The values of the widget
   * @param array  $attributes An array of HTML attributes
   * @param array  $errors     An array of errors
   *
   * @return string An HTML representation of the widget
   *
   * @throws InvalidArgumentException when values type is not array|ArrayAccess
   * 
   * @see sfWidgetFormSchema
   */
  public function render($name, $values = array(), $attributes = array(), $errors = array())
  {
    if (null === $values)
    {
      $values = array();
    }

    if (!is_array($values) && !$values instanceof ArrayAccess)
    {
      throw new InvalidArgumentException('You must pass an array of values to render a widget schema');
    }

    $formFormat = $this->getFormFormatter();

    $rows       = array();
    $hiddenRows = array();
    $errorRows  = array();

    // render each field
    foreach ($this->positions as $name)
    {
      $widget = $this[$name];
      $value  = isset($values[$name]) ? $values[$name] : null;
      $error  = isset($errors[$name]) ? $errors[$name] : array();
      $widgetAttributes = isset($attributes[$name]) ? $attributes[$name] : array();

      if ($widget instanceof sfWidgetForm && $widget->isHidden())
      {
        $hiddenRows[] = $this->updateField($this->renderField($name, $value, $widgetAttributes));
      }
      else
      {
        $field = $this->updateField($this->renderField($name, $value, $widgetAttributes, $error));

        // don't add a label tag and errors if we embed a form schema
        $label  = $widget instanceof sfWidgetFormSchema ? $formFormat->generateLabelName($name) : $formFormat->generateLabel($name);
        $error  = $widget instanceof sfWidgetFormSchema ? array() : $error;

        $rows[] = $widget instanceof sfWidgetFormSchema ? $formFormat->formatEmbeddedRow($label, $field, $error, $this->getHelp($name), null, $name) : $formFormat->formatRowExtended($label, $field, $error, $this->getHelp($name), null, $name);
      }
    }

    if ($rows)
    {
      // insert hidden fields in the last row
      for ($i = 0, $max = count($rows); $i < $max; $i++)
      {
        $rows[$i] = strtr($rows[$i], array('%hidden_fields%' => $i == $max - 1 ? implode("\n", $hiddenRows) : ''));
      }
    }
    else
    {
      // only hidden fields
      $rows[0] = implode("\n", $hiddenRows);
    }

    $errors = $this->updateErrors($errors);
    
    return $formFormat->formatErrorRow($errors).implode('', $rows);
  }
  /**
   * Updates the errors.
   * 
   * Iterates through the errors and formats the messages depending
   * whether it is a normal widget or a embedded form.
   *
   * @param array  $errors     An array of errors
   *
   * @return array|sfValidatorErrorSchema A container with the errors
   */
  public function updateErrors($errors)
  {
    if ($errors)
    {
      $errorSchema = new sfValidatorErrorSchema(new sfValidatorSchema());
      foreach ($errors->getGlobalErrors() as $error) // global errors
      {
        $errorSchema->addError($error);
      }
      foreach ($this->positions as $name)
      {
        if (isset($errors[$name]))
        {
          $error = $errors[$name];
          
          // embedded forms
          if ($this[$name] instanceof sfWidgetFormSchema)
          {
            $label   = strip_tags($this->getFormFormatter()->generateLabelName($name)); // strips link_to from sfDynamicFormEmbedder
            $message = sprintf("The '%s' form has some errors.", $label);
            $errorSchema->addError(new sfValidatorError(new sfValidatorPass(), $message), $name);
          }
          else // normal widgets
          {
            $errorSchema->addError($error, $name);
          }
          
          unset($errors[$name]);
        }
      }
      
      $errors = $errorSchema;
    }
    
    return null;
  }
  /**
   * Updates the fields.
   * 
   * Searchs in the field for lazy names and lazy ids and
   * turn them into real names and real ids.
   *
   * @param string  $field  The html field
   *
   * @return string The html field with the replaced content
   */
  public function updateField($field)
  {
    if (preg_match_all('/@@@(\w+)@@@/', $field, $matches, PREG_SET_ORDER))
    {
      foreach ($matches as $match)
      {
        $field = str_replace($match[0], $this->generateName($match[1]), $field);
      }
    }
    
    if (preg_match_all('/%%%(\w+)%%%/', $field, $matches, PREG_SET_ORDER))
    {
      foreach ($matches as $match)
      {
        $field = str_replace($match[0], $this->generateId($this->generateName($match[1])), $field);
      }
    }

    return $field;
  }
  /**
   * Generates a lazy form name.
   * 
   * Sorrounds the name with special chars for future convertion.
   * 
   * This method is needed when using embedded forms and wants to know the future
   * "name" attribute of a widget, to use for javascript for example.
   *
   * @param string $name The name to convert
   *
   * @return string The generated name
   */
  public function generateLazyName($name)
  {
    return '@@@'.$name.'@@@';
  }
  /**
   * Generates a lazy form id.
   * 
   * Sorrounds the name with special chars for future id convertion.
   * 
   * This method is needed when using embedded forms and wants to know the future
   * "id" attribute of a widget, to use for javascript for example.
   *
   * @param string $name The name to convert
   *
   * @return string The generated id
   */
  public function generateLazyId($name)
  {
    return '%%%'.$name.'%%%';
  }
}
