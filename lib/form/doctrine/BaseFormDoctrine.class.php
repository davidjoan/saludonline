<?php

/**
 * Project form base class.
 *
 * @package    saludonline
 * @subpackage form
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  public function setup()
  {
  }
  
  public function getCamelCaseName()
  {
    return $this->getModelName();
  }
  public function getTable()
  {
    return Doctrine::getTable($this->getModelName());
  }
  
  protected function saveFile($field, $filename = null, sfValidatedFile $file = null)
  {
    if (!$this->validatorSchema[$field] instanceof sfValidatorFile)
    {
      throw new LogicException(sprintf('You cannot save the current file for field "%s" as the field is not a file.', $field));
    }
    if (is_null($file))
    {
      $file = $this->getValue($field);
    }

    $method = sprintf('generate%sFilename', $this->camelize($field));

    if (!is_null($filename))
    {
      return $file->save($filename);
    }
    else if (method_exists($this->object, $method))
    {
      return $file->save($this->object->$method($file));
    }
    else
    {
      return $file->save();
    }
  }
  
  public function updateObject($values = null)
  {
    if (is_null($values))
    {
      $values = $this->values;
    }

    $values = $this->processValues($values);
    $values = $this->updateValues($values);

    $this->object->fromArray($values);
    // embedded forms
    $this->checkEmbeddedForms($values);
    $this->updateObjectEmbeddedForms($values);

    return $this->object;
  }
  protected function updateValues($values)
  {
    return $values;
  }
  protected function checkEmbeddedForms($values, $form = null)
  {
    if (is_null($form))
    {
      $form = $this;
    }
    
    $clone = $form; //clone $form; strange object reseting when cloning
    $to_validate = false;
    foreach ($clone as $name => $value)
    {
      $embeddedFormKeys = array_keys($form->getEmbeddedForms());
      if (!in_array($name, $embeddedFormKeys))
      {
        $to_validate = ($name != 'id' && $name != 'page_id' ? !empty($values[$name]) : false) || $to_validate;
      }
      else
      {
        $embeddedForms = $form->getEmbeddedForms();
        $to_validate_form = $this->checkEmbeddedForms($values[$name], $embeddedForms[$name]);
        
        if (!$to_validate_form)
        {
          $object = $this->getInnerObject($embeddedForms[$name]);
          if ($object && !$object->isNew())
          {
            $object->delete();
          }
          unset($form[$name]);
        }
        
        $to_validate = $to_validate || $to_validate_form;
      }
    }
    
    return $to_validate;
  }
  
  protected function getInnerObject(sfForm $form)
  {
    $object = null;
    if ($form instanceof sfFormDoctrine)
    {
      $object = $form->getObject();
    }
    
    return $object;
  }
}
