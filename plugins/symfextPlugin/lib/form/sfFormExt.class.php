<?php

/**
 * sfFormExt
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfFormExt extends sfFormSymfony
{
  protected
    $labels          = array(),
    $types           = array(),
    $widgetFormatter = null;
    
  /**
   * Constructor
   *
   * @see sfFormSymfony
   */
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    $this->setDefaults($defaults);
    $this->options         = $options;
    $this->localCSRFSecret = $CSRFSecret;
    
    $this->setOption('required_labels', true);
    $this->initialize();
    
    $this->validatorSchema = new sfValidatorSchema();
    $this->widgetSchema    = new sfWidgetFormSchemaExt();
    $this->errorSchema     = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetFormatter = new sfWidgetFormFormatter();
    
    $this->setup();
    $this->configure();
    $this->updateSchemas();
    
    $this->addCSRFProtection($this->localCSRFSecret);
    $this->resetFormFields();
    
    $this->postConfigure();
  }
  /**
   * Initializes the form.
   *
   * Mainly used to declare the labels.
   */
  public function initialize()
  {
  }
  
  /**
   * Update schemas.
   *
   * It updates the validator and widget schemas.
   */
  public function updateSchemas()
  {
    $this->updateValidators();
    $this->updateLabels();
  }
  /**
   * Update validators.
   *
   * Updates validator schema using a kcValidatorBuilder object
   * which configures validators according current types and labels.
   */
  public function updateValidators()
  {
    $validatorBuilder = new ValidatorBuilder($this->types, $this->labels, $this->validatorSchema);
    $this->setValidatorSchema($validatorBuilder->build());
  }
  /**
   * Update labels.
   *
   * It updates the labels and the name format of the widget schema.
   */
  public function updateLabels()
  {
    $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', $this->getName()));
    
    if ($this->getOption('required_labels'))
    {
      $this->updateRequiredLabels();
    }
    
    $this->widgetSchema->setLabels($this->labels);
  }
  /**
   * Update the current form labels.
   *
   * It concats a star at the end of each label
   * which has a required field.
   */
  public function updateRequiredLabels()
  {
    $labels          = array();
    $validatorSchema = $this->getValidatorSchema();
    foreach ($this->labels as $field => $label)
    {
      $label          = rtrim($label, '*');
      $labels[$field] = $label;
      if (
           isset($validatorSchema[$field]) && 
           !$validatorSchema[$field] instanceof sfValidatorSchema && 
           $validatorSchema[$field]->getOption('required')
         )
      {
        $labels[$field] .= '*';
      }
    }
    
    $this->labels = $labels;
  }
  
  /**
   * Executes post configuration in the form.
   *
   * Mainly used to execute some actions after the form is
   * entirely built.
   * 
   * Notifies the 'form.post_configure' event.
   * Notifies the 'form.%forms_name%.post_configure' event.
   */
  public function postConfigure()
  {
    if (self::$dispatcher)
    {
      self::$dispatcher->notify(new sfEvent($this, 'form.post_configure'));
      self::$dispatcher->notify(new sfEvent($this, sprintf('form.%s.post_configure', $this->getName())));
    }
  }
  
  /**
   * Reconfigures the form.
   *
   * Mainly used when making some changes and wants to 
   * rebuild the form.
   * 
   * Experimental: If problems arise when using this method,
   *               instantiate the form again.
   */
  public function reconfigure()
  {
    $this->initialize();
    $this->setup();
    $this->configure();
    $this->updateSchemas();
    $this->addCSRFProtection($this->localCSRFSecret);
    $this->resetFormFields();
  }
  
  /**
   * Renders the formatted errors for the visible fields
   * of this form.
   *
   * @return string The rendered errors
   *
   * @todo Test
   */
  public function renderErrors()
  {
    $errors = array();
    foreach ($this->getVisibleFormFieldsNames() as $name)
    {
      if ($this[$name]->hasError())
      {
        $errors[] = $this[$name]->getError();
      }
    }

    return $this->getWidgetSchema()->getFormFormatter()->formatErrorRow($errors);
  }
  
  /**
   * Executes the tie method before binding the tainted values and files.
   *
   * @see sfForm
   */
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $this->tie($taintedValues, $taintedFiles);
    
    parent::bind($taintedValues, $taintedFiles);
  }
  /**
   * Ties the form with input values.
   *
   * It updates the validator schema validation using the methods 
   * shouldActivateValidation and activateValidation, based on the
   * incoming values and files.
   * 
   * Mostly used with sfDynamicFormEmbedder functionality, to not 
   * validate those forms that don't follow the rules given by 
   * shouldActivateValidation method.
   * 
   * @param array             $taintedValues   An array of input values
   * @param array             $taintedFiles    An array of uploaded files (in the $_FILES or $_GET format)
   * @param sfValidatorSchema $validatorSchema A sfValidatorSchema instance
   */
  public function tie(array $taintedValues = null, array $taintedFiles = null, sfValidatorSchema $validatorSchema = null)
  {
    if (is_null($validatorSchema))
    {
      $validatorSchema = $this->getValidatorSchema();
    }
    
    foreach ($this->embeddedForms as $name => $embeddedForm)
    {
      if (isset($taintedValues[$name]))
      {
        if ($embeddedForm->shouldActivateValidation($taintedValues[$name]))
        {
          $embeddedForm->activateValidation($validatorSchema[$name]);
        }
        if ($embeddedForm->hasEmbeddedForms())
        {
          $taintedFilesName = isset($taintedFiles[$name]) ? $taintedFiles[$name] : array();
          $embeddedForm->tie($taintedValues[$name], $taintedFilesName, $validatorSchema[$name]);
        }
      }
    }
  }
  /**
   * Deactivate the validation of the current form.
   * 
   * @see tie()
   */
  public function deactivateValidation()
  {
  }
  /**
   * Check if the form should be validated based on the incoming values.
   * 
   * If any incoming value is different from empty then the form should
   * be validated.
   * 
   * @return boolean Whether or not the form should be validated
   * 
   * @see tie()
   */
  public function shouldActivateValidation($taintedValues)
  {
    $should = false;
    foreach ($taintedValues as $name => $taintedValue)
    {
      if (is_array($taintedValue))
      {
        $should = $this->shouldActivateValidation($taintedValue) || $should;
      }
      else
      {
        $should = ($name != 'id' ? !empty($taintedValue) : false) || $should;
      }
      
      if ($should)
      {
        break;
      }
    }
    
    return $should;
  }
  /**
   * Activate the validation of the current form.
   * 
   * @param sfValidatorSchema $validatorSchema A sfValidatorSchema instance
   * 
   * @see tie()
   */
  public function activateValidation($validatorSchema)
  {
  }
  
  /**
   * Gets the camel case version of the form's name,
   * without the "form" word at the end.
   * 
   * @return string Name in camel case
   */
  public function getCamelCaseName()
  {
    $class_name = get_class($this);
    $class_name = substr($class_name, 0, -4);
    
    return $class_name;
  }
  /**
   * Gets the underscore case version of the form's name.
   * 
   * @return string Name in underscore case
   */
  public function getName()
  {
    return sfInflector::underscore($this->getCamelCaseName());
  }
  
  /**
   * Generates a lazy name.
   *
   * @see sfWidgetFormSchemaExt
   */
  public function generateLazyName($name)
  {
    return $this->getWidgetSchema()->generateLazyName($name);
  }
  /**
   * Generates a lazy id.
   *
   * @see sfWidgetFormSchemaExt
   */
  public function generateLazyId($name)
  {
    return $this->getWidgetSchema()->generateLazyId($name);
  }
  
  /**
   * Check if the form has an embedded form with
   * the associated name.
   *
   * @return boolean Whether or not the embedded form exists 
   */
  public function hasEmbeddedForm($name)
  {
    return array_key_exists($name, $this->embeddedForms);
  }
  /**
   * Check if the form has embedded forms.
   *
   * @return boolean Whether or not the form has embedded forms 
   */
  public function hasEmbeddedForms()
  {
    return (boolean) count($this->embeddedForms);
  }
  
  public function addLabels(array $labels)
  {
    $this->labels = array_merge($this->labels, $labels);
  }
  public function getLabel($name)
  {
    return $this->labels[$name];
  }
  public function getLabels()
  {
    return $this->labels;
  }
  public function setLabel($name, $label)
  {
    $this->labels[$name] = $label;
  }
  public function setLabels(array $labels)
  {
    $this->labels = $labels;
  }
  
  public function addTypes(array $types)
  {
    $this->types = array_merge($this->types, $types);
  }
  public function getType($name)
  {
    return $this->types[$name];
  }
  public function getTypes()
  {
    return $this->types;
  }
  public function setType($name, $type)
  {
    $this->labels[$name] = $type;
  }
  public function setTypes(array $types)
  {
    $this->types = $types;
  }
  
  /**
   * Returns the associated widget formatter.
   *
   * @return sfWidgetFormFormatter The associated widget formatter instance
   */
  public function getWidgetFormatter()
  {
    return $this->widgetFormatter;
  }
  
  /**
   * Add validators associated with this form.
   *
   * @param array $validators An array of named validators
   *
   * @return sfForm The current form instance
   */
  public function addValidators(array $validators)
  {
    foreach ($validators as $name => $validator)
    {
      $this->validatorSchema[$name] = $validator;
    }
    
    $this->resetFormFields();
    
    return $this;
  }
  /**
   * Add widgets associated with this form.
   *
   * @param array $widgets An array of named widgets
   *
   * @return sfForm The current form instance
   */
  public function addWidgets(array $widgets)
  {
    foreach ($widgets as $name => $widget)
    {
      $this->widgetSchema[$name] = $widget;
    }
    
    $this->resetFormFields();
    
    return $this;
  }
  /**
   * Sets the widgets associated with this form.
   *
   * @return sfForm The current form instance
   * 
   * @see sfForm
   */
  public function setWidgets(array $widgets)
  {
    $this->setWidgetSchema(new sfWidgetFormSchemaExt($widgets));
    
    return $this;
  }
  /**
   * Add default values for the form.
   *
   * @param array $defaults An array of default values
   *
   * @return sfForm The current form instance
   */
  public function addDefaults(array $defaults)
  {
    $this->defaults = array_merge($this->defaults, $defaults);
    
    return $this;
  }
  
  /**
   * Gets the stylesheet paths associated with the form.
   * 
   * The getStylesheets method from the sfForm class, 
   * just take in count those stylesheets from the widgets,
   * forgetting about the stylesheets from the embedded forms.
   *
   * This method corrects that situation taking in count also
   * the stylesheets from the embedded forms.
   *
   * @return array An array of stylesheet paths
   * 
   * @see sfForm
   */
  public function getStylesheets()
  {
    $stylesheets = array();
    foreach ($this->embeddedForms as $embeddedForm)
    {
      $stylesheets = array_merge($stylesheets, $embeddedForm->getStylesheets());
    }
    
    $stylesheets = array_merge($stylesheets, parent::getStylesheets(), $this->getFormStylesheets());
    
    return array_unique($stylesheets);
  }
  
  /**
   * Gets the stylesheet paths associated with the form 
   * (not with the widget schema).
   * 
   * @return array An array of stylesheet paths
   */
  public function getFormStylesheets()
  {
    return array();
  }
  
  /**
   * Gets the JavaScript paths associated with the form.
   * 
   * The getJavascripts method from the sfForm class, 
   * just take in count those javascripts from the widgets,
   * forgetting about the javascripts from the embedded forms.
   *
   * This method corrects that situation taking in count also
   * the javascripts from the embedded forms.
   *
   * @return array An array of JavaScript paths
   * 
   * @see sfForm
   */
  public function getJavaScripts()
  {
    $javascripts = array();
    foreach ($this->embeddedForms as $embeddedForm)
    {
      $javascripts = array_merge($javascripts, $embeddedForm->getJavascripts());
    }
    
    $javascripts = array_merge($javascripts, parent::getJavascripts(), $this->getFormJavascripts());
    
    return array_unique($javascripts);
  }
  
  /**
   * Gets the JavaScript paths associated with the form 
   * (not with the widget schema).
   * 
   * @return array An array of JavaScript paths
   */
  public function getFormJavascripts()
  {
    return array();
  }
  
  /**
   * Returns the form field associated with the name (implements the ArrayAccess interface).
   * 
   * Method overwritten to successfully use sfFormFieldSchemaExt and sfFormFieldExt.
   *
   * @see sfForm
   */
  public function offsetGet($name)
  {
    if (!isset($this->formFields[$name]))
    {
      if (!$widget = $this->widgetSchema[$name])
      {
        throw new InvalidArgumentException(sprintf('Widget "%s" does not exist.', $name));
      }

      if ($this->isBound)
      {
        $value = isset($this->taintedValues[$name]) ? $this->taintedValues[$name] : null;
      }
      else if (isset($this->defaults[$name]))
      {
        $value = $this->defaults[$name];
      }
      else
      {
        $value = $widget instanceof sfWidgetFormSchema ? $widget->getDefaults() : $widget->getDefault();
      }

      $class = $widget instanceof sfWidgetFormSchema ? 'sfFormFieldSchemaExt' : 'sfFormFieldExt';

      $this->formFields[$name] = new $class($widget, $this->getFormFieldSchema(), $name, $value, $this->errorSchema[$name]);
    }

    return $this->formFields[$name];
  }
  /**
   * Removes a field from the form.
   * 
   * Method overwritten to also unset the associated label and type variables.
   *
   * @see sfForm
   */
  public function offsetUnset($offset)
  {
    unset
    (
      $this->labels[$offset],
      $this->types[$offset]
    );
    
    parent::offsetUnset($offset);
  }
  
  /**
   * Method overwritten to successfully use sfFormFieldSchemaExt.
   *
   * @see sfForm
   */
  public function getFormFieldSchema()
  {
    if (null === $this->formFieldSchema)
    {
      $values = $this->isBound ? $this->taintedValues : array_merge($this->widgetSchema->getDefaults(), $this->defaults);

      $this->formFieldSchema = new sfFormFieldSchemaExt($this->widgetSchema, null, null, $values, $this->errorSchema);
    }

    return $this->formFieldSchema;
  }
  
  /**
   * Gets the visible form fields names.
   * 
   * A visible name is a name which not belongs to a hidden field
   * or a embedded form.
   * 
   * @return array An array with the visibles field names from the form
   */
  public function getVisibleFormFieldsNames()
  {
    return $this->getFormFieldsNames('visible');
  }
  /**
   * Gets the hidden form fields names.
   * 
   * @return array An array with the hidden field names from the form
   */
  public function getHiddenFormFieldsNames()
  {
    return $this->getFormFieldsNames('hidden');
  }
  /**
   * Gets the embedded forms names.
   * 
   * @return array An array with the embedded form names from the form
   */
  public function getEmbeddedFormsNames()
  {
    return $this->getFormFieldsNames('embedded');
  }
  /**
   * Gets the forms names.
   * 
   * The type optional parameter can be:
   * 
   *  * visible
   *  * hidden
   *  * embedded
   * 
   * @param string $type The type of the field names to return
   * 
   * @return array An array with the form names from the form
   */
  public function getFormFieldsNames($type = null)
  {
    $names = array();
    foreach ($this->widgetSchema->getPositions() as $name)
    {
      $add = true;
      switch ($type)
      {
        case 'visible'  : $add = !$this[$name]->isHidden() && !$this->hasEmbeddedForm($name); break;
        case 'hidden'   : $add = $this[$name]->isHidden()                                   ; break;
        case 'embedded' : $add = $this->hasEmbeddedForm($name)                              ; break;
      }
      
      if ($add)
      {
        $names[] = $name;
      }
    }
    
    return $names;
  }
  
  protected function getCurrentRequestField($field, $form_name = null)
  {
    $form_name = $form_name ? $form_name : $this->getName();
    $params = $this->getRequest()->getParameter($form_name);

    return $params[$field];
  }
  public function loadHelpers($helpers)
  {
    Toolkit::loadHelpers($helpers);
  }
  
  protected function getContext()
  {
    return sfContext::getInstance();
  }
  protected function getRequest()
  {
    return $this->getContext()->getRequest();
  }
  protected function getRouting()
  {
    return $this->getContext()->getRouting();
  }
  protected function getUser()
  {
    return $this->getContext()->getUser();
  }
  protected function genUrl($uri)
  {
    return $this->getContext()->getController()->genUrl($uri);
  }
}
