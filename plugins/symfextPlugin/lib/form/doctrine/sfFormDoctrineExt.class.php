<?php

/**
 * sfFormDoctrineExt
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
abstract class sfFormDoctrineExt extends sfFormDoctrine
{
  /**
   * Gets the camel case version of the form's name.
   * 
   * @see BaseForm
   */
  public function getCamelCaseName()
  {
    return $this->getModelName();
  }
  /**
   * Gets the table object associated with the model
   * of the form.
   * 
   * @return DoctrineTable Table of the form
   */
  public function getTable()
  {
    return Doctrine::getTable($this->getModelName());
  }
  
  /**
   * Updates and delegates the saving of the current object.
   * 
   * Method overwritten to properly used the method
   * realSave.
   * 
   * @see sfFormObject
   */
  protected function doSave($con = null)
  {
    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $this->updateObject();

    $this->realSave($con);

    // embedded forms
    $this->saveEmbeddedForms($con);
  }
  /**
   * Updates and saves the current object.
   *
   * @param mixed $con A connection object
   */
  protected function realSave($con)
  {
    $this->object->save($con);
  }
  /**
   * Updates the values of the object with the cleaned up values.
   *
   * Method overwritten to properly used the
   * updateValues and updateEmbeddedForms methods.
   *
   * @see sfFormObject
   */
  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }

    $values = $this->processValues($values);
    $values = $this->updateValues($values);

    $this->doUpdateObject($values);

    $this->updateEmbeddedForms($values);
    $this->updateObjectEmbeddedForms($values);

    return $this->getObject();
  }
  /**
   * Updates cleaned up values.
   *
   * @param  array $values An array of values
   * 
   * @return array An array of updated values
   */
  protected function updateValues($values)
  {
    return $values;
  }
  /**
   * Verifies that all the embedded forms, which should
   * not be validated, can be unembedded and not have 
   * embedded valid forms; are unset and if have an existent
   * object, it is deleted.
   *
   * @param  array $values An array of values
   * @param  array $form An optional form
   * 
   * @return boolean Whether or not the total form can be unset
   */
  public function updateEmbeddedForms($values, $form = null)
  {
    if (null === $form)
    {
      $form = $this;
    }
    
    $total_unset = true;
    foreach ($form->getEmbeddedForms() as $name => $embeddedForm)
    {
      if ($embeddedForm instanceof sfFormObject)
      {
        $to_unset = $this->updateEmbeddedForms($values[$name], $embeddedForm);
        if (!$embeddedForm->shouldActivateValidation($values[$name]) && $to_unset && $embeddedForm->canBeUnembed())
        {
          if (!$embeddedForm->getObject()->isNew())
          {
            $embeddedForm->getObject()->delete();
          }
          unset($form[$name]);
        }
        else
        {
          $total_unset = false;
        }
      }
      else
      {
        $this->updateEmbeddedForms($values[$name], $embeddedForm);
      }
    }
    
    return $total_unset;
  }
  /**
   * Returns true if the current form can be unembed.
   *
   * @return Boolean true if the current form can be unembed
   * 
   * @see updateEmbeddedForms()
   */
  public function canBeUnembed()
  {
    return true;
  }
  
  /**
   * Removes the current file for the field.
   * 
   * Delegates the real remove of the file to the model object.
   *
   * @param string $field The field name
   */
  protected function removeFile($field)
  {
    $this->object->removeFile($field);
  }
  /**
   * Saves the current file for the field.
   * 
   * Delegates the real save of the file to the model object.
   *
   * @param  string          $field    The field name
   * @param  string          $filename The file name of the file to save
   * @param  sfValidatedFile $file     The validated file to save
   *
   * @return string The filename used to save the file
   */
  protected function saveFile($field, $filename = null, sfValidatedFile $file = null)
  {
    if (!$this->validatorSchema[$field] instanceof sfValidatorFile)
    {
      throw new LogicException(sprintf('You cannot save the current file for field "%s" as the field is not a file.', $field));
    }

    if (null === $file)
    {
      $file = $this->getValue($field);
    }

    $method = sprintf('generate%sFilename', $this->camelize($field));

    if (null !== $filename)
    {
      return $this->object->saveFile($file, $filename);
    }
    else if (method_exists($this, $method))
    {
      return $this->object->saveFile($file, $this->$method($file));
    }
    else if (method_exists($this->object, $method))
    {
      return $this->object->saveFile($file, $this->object->$method($file));
    }
    else
    {
      return $this->object->saveFile($file);
    }
  }
}
