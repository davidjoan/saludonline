<?php

/**
 * sfDoctrineRecordExt
 *
 * @package    symfext
 * @subpackage doctrine
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
abstract class sfDoctrineRecordExt extends sfDoctrineRecord
{
  protected
    $wasNew = false; // true if and only if this record was new and then save just one time

  /**
   * Returns true if the column is modified.
   *
   * @param string $column The column to evaluate
   *
   * @return boolean True if the column is modified, otherwise false
   */
  public function isColumnModified($column)
  {
    return in_array($column, $this->_modified);
  }
  
  /**
   * Returns whether or not the record was new.
   *
   * This method and its variable are used to avoid this:
   * 
   * [code]
   *   $is_new = $this->isNew();
   *   
   *   parent::save($con);
   *   
   *   if ($is_new)
   *   {
   *     ...
   *   }
   * [/code]
   *
   * @return boolean True if the record was new, otherwise false
   */
  public function wasNew()
  {
    return $this->wasNew;
  }
  /**
   * Saves the record.
   * 
   * @param Doctrine_Connection $conn     optional connection parameter
   * 
   * @throws Exception                    if record is not valid and validation is active
   * 
   * @see Doctrine_Record
   */
  public function save(Doctrine_Connection $conn = null)
  {
    $this->wasNew = $this->isNew();
    
    parent::save($conn);
  }

  /**
   * The following methods are related with the managing of files.
   *
   * In the Table of the model should exist two methods:
   *   * get%field%Dir   : Indicate the actual directory where the files should be saved.
   *   * get%field%Path  : Indicate the actual path of the file.
   *
   * These two methods are used by the following methods.
   */
  /**
   * Generates a filename based on the method and with a tree level path.
   *
   * The filename is generated with a random number to enforce uniqueness.
   *
   * @param  string          $field    The field of the file
   * @param  string          $method   The method to use to generate
   * @param  sfValidatedFile $file     The validated file to save
   *
   * @return string The generated filename
   */
  public function generateFilename($field, $method, sfValidatedFile $file)
  {
    $extension = Filekit::convertExtension($file->getExtension($file->getOriginalExtension()));
    $path      = Stringkit::fixFilename($this->$method());
    $path      = $path.'_'.rand(1, 99999).$extension;
    $hash      = Filekit::getHashPathForLevel($path, 3);
    $filename  = $hash.'/'.$path;

    return trim($filename, '\/');
  }
  /**
   * Removes the current file for the field.
   *
   * Tree ways of removing a file from a dotrine record:
   *  1.- Through the delete action.
   *  2.- Through the delete file button of the widget.
   *  3.- Updating with a new image, automatically deleting the old one.
   *
   *  In all of these DoctrineRecord::removeFile is used.
   *
   * @param string $field The field name
   */
  public function removeFile($field)
  {
    $file = $this->getFileDirectory($field);
    if (is_file($file))
    {
      unlink($file);
    }
  }
  /**
   * Saves the current file for the field.
   *
   * @param  sfValidatedFile $file     The validated file to save
   * @param  string          $filename The file name of the file to save
   *
   * @return string The filename used to save the file
   */
  public function saveFile(sfValidatedFile $file, $filename)
  {
    return $file->save($filename);
  }
  /**
   * Deletes this data access object and all the related composites.
   *
   * Also deletes all the files associated with this record.
   *
   * @return boolean      true if successful
   */
  public function delete(Doctrine_Connection $conn = null)
  {
    $ret = parent::delete($conn);

    foreach ($this->_data as $key => $val)
    {
      if ($this->getFieldDirectory($key))
      {
        $this->removeFile($key);
      }
    }

    return $ret;
  }
  /**
   * Returns the complete directory of the field.
   *
   * @example C:\wamp\www\flexiwik_1.0\web\uploads\category_images
   *
   * @param  string $field  The field name
   *
   * @return string The complete directory
   */
  public function getFieldDirectory($field)
  {
    $getFieldDirectory = sprintf('get%sDir', sfInflector::camelize($field));
    $directory         = method_exists($this->getTable(), $getFieldDirectory) ? $this->getTable()->$getFieldDirectory() : '';

    return $directory;
  }
  /**
   * Returns the complete path of the directory of the field.
   *
   * @example /flexiwik_1.0/web/uploads/category_images
   *
   * @param  string $field  The field name
   *
   * @return string The complete path
   */
  public function getFieldPath($field)
  {
    $getFieldPath = sprintf('get%sPath', sfInflector::camelize($field));
    $path         = method_exists($this->getTable(), $getFieldPath) ? $this->getTable()->$getFieldPath() : '';

    return $path;
  }
  /**
   * Returns the complete name of the file.
   *
   * @example C:\wamp\www\flexiwik_1.0\web\uploads\category_images\example1.jpg
   *
   * @param  string $field  The field name
   *
   * @return string The complete name of the file
   */
  public function getFileDirectory($field)
  {
    return $this->getFieldDirectory($field).'/'.$this->$field;
  }
  /**
   * Returns the complete path of the file.
   *
   * @example /flexiwik_1.0/web/uploads/category_images/example1.jpg
   *
   * @param  string $field  The field name
   *
   * @return string The complete path of the file
   */
  public function getFilePath($field)
  {
    return $this->getFieldPath($field).'/'.$this->$field;
  }





















  
  
  
  
  
  
  
  
  
  
  
  







  public function __call($method, $arguments)
  {
    try
    {
      $verb = substr($method, 0, 3);
      $name = substr($method, 3);
      if (substr($method, 0, 2) == 'is')
      {
        $name = sfInflector::underscore(substr($method, 2));
        if (in_array($name, (array) $this->getTable()->getOption('boolean_columns')))
        {
          return $this->$name == constant(get_class($this->getTable()).'::YES');
        }
        elseif ($column = $this->getTypeColumn($name))
        {
          return $column[1];
        }
        
        return parent::__call($method, $arguments);
      }
      elseif ($verb == 'get')
      {
        if (!strpos(sfInflector::underscore($name), '_'))
        {
          return parent::__call($method, $arguments);
        }
        
        foreach (array_keys($this->getTable()->getSingleRelations()) as $relation)
        {
          $relation_name = substr($name, 0, strlen($relation));
          if ($relation_name == $relation)
          {
            $field = sfInflector::underscore(substr($name, strlen($relation)));
            if ($field)
            {
              return $this->{'has'.$relation}() ? $this->$relation->$field : '';
            }
          }
        }
        
        if (substr($method, -4) == 'Name')
        {
          $name = substr($method, 3, strlen($method) - 7);
          if (!$name) // getName
          {
            return parent::__call($method, $arguments);
          }
          
          $name = sfInflector::underscore($name);
          if (in_array($name, (array) $this->getTable()->getOption('boolean_columns')))
          {
            $assertions = $this->getTable()->getAssertions();
            return $assertions[$this->$name];
          }
          elseif (in_array($name, (array) $this->getTable()->getOption('type_columns')))
          {
            $types = $this->getTable()->{'get'.sfInflector::camelize($name).'s'}();
            return $types[$this->$name];
          }
        }
      }
      elseif ($verb == 'has')
      {
        return $this->relatedExists($name);
      }
      elseif ($verb == 'add')
      {
        $collectionName = $name.'s';

        return $this->$collectionName->add($arguments[0]);
      }
      
      return parent::__call($method, $arguments);
    }
    catch (Exception $e)
    {
      return parent::__call($method, $arguments);
    }
  }
  
  protected function getTypeColumn($name)
  {
    $type_columns = (array) $this->getTable()->getOption('type_columns');
    foreach ($type_columns as $column)
    {
      $length = strlen($column);
      if (substr($name, -$length) == $column)
      {
        $class = new ReflectionClass(get_class($this->getTable()));
        $name     = substr($name, 0, strlen($name) - $length - 1);
        $constant = kcInflector::constantize($column.'_'.$name);
        foreach ($class->getConstants() as $const => $value)
        {
          if ($constant == $const)
          {
            return array(1, $this->$column == $value);
          }
        }
      }
    }
  }
  
  
  
  
  
  
  
  
  
  
  public function toTemplate($force = true)
  {
    $template_class = $this->getTable()->getComponentName().'Template';
    
    if (class_exists($template_class))
    {
      $template = new $template_class($this);
      
      return $template;
    }
    
    if ($force)
    {
      throw new RuntimeException(sprintf('The "%s" class does not exist. You can\'t convert a sfDoctrineRecordExt to a template without the template class', $template_class));
    }
    
    return $this;
  }
}
