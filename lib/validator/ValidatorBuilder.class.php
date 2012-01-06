<?php

/**
 * ValidatorBuilder builds and assigns complex validators.
 *
 * @package    withmory
 * @subpackage validator
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class ValidatorBuilder extends sfValidatorBuilderExt
{
  protected
    // normal messages
    $msgEmpty         = "EL campo '%field%' no puede ser dejado vacío.",
    $msgEmptyList     = "Por favor, seleccione al menos una opción en el campo '%field%'.",
    $msgLong          = "El campo '%field%' es muy largo (%max_length% caracteres max).",
    $msgShort         = "El campo '%field%' es muy corto (%min_length% caracteres min).",
    $msgCombo         = "Por favor, elige una opción en el campo '%field%'.",
    $msgComboInvalid  = "El campo '%field%' tiene un error en la opción elegida.",
    $msgSimpleRegex   = "EL campo '%field%' contiene caracteres prohibidos.",
    $msgRegex         = "El campo '%field%' tiene caracteres prohibidos: &nbsp; %chars%",
    $msgUrl           = "Por favor, escriba una dirección web correcta en el campo '%field%'.",
    $msgEmail         = "Por favor, escriba un email correcto en el campo '%field%'.",
    $msgDate          = "Por favor, elija una fecha correcta en el campo '%field%'.",
    $msgDateRange     = "La fecha de inicio debe ser anterior a la fecha fin en el campo '%field%'.",
    $msgMin           = "El campo '%field%' debe contener un valor mayor o igual a %min%.",
    $msgMax           = "El campo '%field%' debe contener un valor menor o igual a %max%.",
    
    // file messages
    $msgMaxSize       = "El campo '%field%' tiene un archivo muy grande (Tamaño máximo: %max_size% bytes).",
    $msgMimeTypes     = "El campo '%field%' tiene un tipo de archivo inválido.",
    $msgPartialFile   = "El archivo del campo '%field%' fue tan solo parcialmente subido.",
    $msgNoTmpDir      = "El archivo del campo '%field%' identifica un directorio faltante.",
    $msgCantWrite     = "El archivo del campo '%field%' no puede ser escrito.",
    $msgFileExtension = "El campo '%field%' tiene un archivo impedido de subir por su extensión.";
    
  protected function updatePostValidators($validator)
  {
    if ($validator instanceof sfValidatorDoctrineUnique)
    {
      $column = $validator->getOption('column');
      if (is_array($column))
      {
        $column = $this->getLabelFields($column);
        $fields = implode(", ", $column);
      }
      else
      {
        $fields = $this->labels[$column];
      }
      
      $validator->setMessage('invalid', sprintf('Un registro con el mismo campo "%s" ya existe.<br/>', $fields));
      
      return;
    }
    
    if ($validator instanceof LoginValidator)
    {
      $column = $validator->getOption('column');
      if (is_array($column))
      {
        $column = $this->getLabelFields($column);
        $fields = implode(", ", $column);
      }
      else
      {
        $fields = $this->labels[$column];
      }
      
      $validator->setMessage('invalid', sprintf('"%s" incorrecto.', $fields));
      
      return;
    }
    
    parent::updatePostValidators($validator);
  }
  
  protected function getLabelFields($fields)
  {
    $labels = array();
    foreach ($fields as $field)
    {
      if (isset($this->labels[$field]))
      {
        $labels[] = $this->labels[$field];
      }
      else
      {
        $labels[] = $field;
      }
    }
    
    return $labels;
  }
}
