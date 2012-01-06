<?php

/**
 * sfImageExt.
 * 
 * @package    lib
 * @subpackage image
 * @author     David Joan Tataje Mendoza <dtataje@datasolutions.pe>
 */
class sfImageExt extends sfImage
{
  /**
   * Returns an adapter class of the specified type
   * 
   * If the name param is an empty string then the method
   * tries to create first an image magick adapter, if the
   * extension is not enabled then fallbacks to a gd adapter.
   * If gd adapter is not enabled either then an exception is thrown.
   * 
   * @param $name The name of the adapter
   * 
   * @return sfImageTransformAdapterAbstract An instance of the desired adapter
   */
  protected function createAdapter($name)
  {
    if ('' == $name)
    {
      try
      {
        $adapter = parent::createAdapter('ImageMagick');
      }
      catch (sfImageTransformException $e)
      {
        try
        {
          $adapter = parent::createAdapter('GD');
        }
        catch (sfImageTransformException $e)
        {
          throw new sfImageTransformException('Neither GD, nor ImageMagick, image libraries are enabled. Enable at least one of them.');
        }
      }
    }
    else
    {
      $adapter = parent::createAdapter($name);
    }
    
    return $adapter;
  }
  
  /**
   * Returns a set of mime types according the 
   * image extensions activated.
   * 
   * @return array[string] The mime types allowed
   */
  public static function getAllowedMimeTypes()
  {
    $gd = array
          (
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/x-png',
            'image/gif',
          );
    
    $imagick = array_merge($gd, array('image/bmp'));
    
    $mimes = array();
    if (extension_loaded('imagick'))
    {
      $mimes = $imagick;
    }
    elseif (extension_loaded('gd'))
    {
      $mimes = $gd;
    }
    
    return $mimes;
  }
}
