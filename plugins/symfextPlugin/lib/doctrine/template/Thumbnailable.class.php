<?php

/**
 * Doctrine_Template_Thumbnailable
 *
 * @package     symfext
 * @subpackage  template
 * @author      Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class Doctrine_Template_Thumbnailable extends Doctrine_Template
{
  /**
   * Creates a thumbnail from the image of the field value.
   * 
   * @param  string  $field  The name of the field
   * @param  integer $width  The desired width (180 by default)
   * @param  integer $height The desired height (if null defaults to the width)
   */
  public function createThumbnail($field,$mime = null, $width = 180, $height = null)
  {
    $directory = $this->getInvoker()->getFieldDirectory($field);
    $image     = $directory.'/'.$this->getInvoker()->$field;

    if (is_file($image))
    {
      $thumbnail = new sfImageExt($image, $mime);

      $directory = $directory.'/thumb/'.$this->getInvoker()->$field;
      if (Toolkit::createDirectory($directory))
      {
        $height         = null === $height ? $width : $height;
        $thumbnail_name = sprintf('%s/%spx-%s', $directory, $width, $this->getFileName($field));
        $thumbnail->thumbnail($width, $height, 'scale');
        $thumbnail->setQuality(80);
        $thumbnail->saveAs($thumbnail_name);
      }
    }
  }
  /**
   * Deletes the thumbnail directory of the given field.
   * 
   * This method should be used in the removeFile method of the model.
   * 
   * @param  string  $field  The name of the field
   */
  public function deleteThumbnailDirectory($field)
  {
    if ($this->getInvoker()->$field)
    {
      $directory = $this->getInvoker()->getFieldDirectory($field);
      $directory = $directory.'/thumb/'.$this->getInvoker()->$field;
      Toolkit::deleteDirectory($directory);
    }
  }
  
  /**
   * Returns whether or not the thumbnail exists.
   * 
   * @param  string  $field  The name of the field
   * @param  integer $width  The width of the thumbnail)
   * 
   * @return boolean True if the thumbnail exists, false otherwise
   */
  public function existsThumbnail($field, $width)
  {
    $path = $this->getThumbnailFileDirectory($field, $width);
    
    return is_file($path) && file_exists($path);
  }
  /**
   * Extracts the file name from the string.
   * 
   * @param  string  $field  The name of the field
   * 
   * @return string  The file name
   */
  public function getFileName($field)
  {
    return substr($this->getInvoker()->$field, strrpos($this->getInvoker()->$field, '/') + 1);
  }
  /**
   * Returns the complete name of the thumbnail file.
   * 
   * @example C:\wamp\www\flexiwik_1.0\web\uploads\category_images\thumb\example1.jpg\180px-example1.jpg
   * 
   * @param  string $field  The field name
   * @param  integer $width  The width of the thumbnail)
   *
   * @return string The complete name of the thumbnail file
   */
  public function getThumbnailFileDirectory($field, $width)
  {
    return sprintf('%s/thumb/%s/%spx-%s', $this->getInvoker()->getFieldDirectory($field), $this->getInvoker()->$field, $width, $this->getFileName($field));
  }
  /**
   * Returns the complete path of the thumbnail file.
   * 
   * @example /flexiwik_1.0/web/uploads/category_images/thumb/example1.jpg/180px-example1.jpg
   * 
   * @param  string $field  The field name
   * @param  integer $width  The width of the thumbnail)
   *
   * @return string The complete path of the thumbnail file
   */
  public function getThumbnailFilePath($field, $width)
  {
    return sprintf('%s/thumb/%s/%spx-%s', $this->getInvoker()->getFieldPath($field), $this->getInvoker()->$field, $width, $this->getFileName($field));
  }
}
