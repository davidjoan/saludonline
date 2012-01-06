<?php

/**
 * sfWidgetFormAjaxInputFile
 * 
 * Represents an ajax file upload widget.
 * 
 * @package    symfext
 * @subpackage widget
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormAjaxInputFile extends sfWidgetFormInputFile
{
  /**
   * Configures the widget.
   * 
   * Available options:
   *
   *  * file_src:        The path of the current image (required)
   *  * url:             The target url for the image uploading (required)
   *  * delete_label:    The label for the delete button
   *  * template:        The HTML template to use to render this widget when in edit mode
   *                     The available placeholders are:
   *                       * %image_id% (the image id)
   *                       * %image_path% (the image path)
   *                       * %input% (the image upload widget)
   *                       * %delete_button% (the delete button)
   *                       * %file% (the file tag)
   *
   *  * loading_image:   The image to show when uploading the image file
   * 
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInputFile
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addRequiredOption('file_src');
    $this->addRequiredOption('url');
    $this->addOption('delete_label', 'Delete');
    $this->addOption('template'     , '<div id="msg_%image_id%"></div> <br/> <a href="%image_path%" target="_blank">%file%</a><br />%input% %delete_button%');
    $this->addOption('loading_image', 'general/snake.gif');
  }
  
  /**
   * Renders the widget.
   * 
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetFormInput
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $existsImage      = $this->getOption('file_src') != '';
    
    $input            = parent::render($name, $value, array_merge($attributes, array('style' => 'display: '.($existsImage ? 'none;' : 'block;'), 'onKeyDown' => 'return false', 'onKeyPress' => 'return false')), $errors);
    
    $deleteButtonName = $this->getFixedName($name, 'button');
    $deleteButton     = $this->renderTag('input', array_merge(array('type' => 'button', 'name' => $deleteButtonName, 'value' => $this->getOption('delete_label'), 'style' =>  'display: '.($existsImage ? 'block;' : 'none;'))), $attributes);
    
    $imageName        = $this->getFixedName($name, 'image');
    $image            = $this->renderTag('img', array_merge(array('src' => $this->getOption('file_src'), 'name' => $imageName, 'style' => 'display: '.($existsImage ? 'block;' : 'none;'))), $attributes);
    
    return strtr($this->getOption('template'), array
           (
             '%image_id%'      => $this->generateId($imageName),
             '%input%'         => $input, 
             '%file%'          => $image, 
             '%image_path%'    => $this->getOption('file_src'),
             '%delete_button%' => $deleteButton
           )).
           sprintf
           (
             '
               <script type="text/javascript">
                 new sfWidgetFormAjaxInputFile("%s", "%s", "%s", "%s", "%s");
               </script>
             ',
             $this->getOption('url'),
             $this->generateId($name),
             $this->generateId($imageName),
             $this->generateId($deleteButtonName),
             sfConfig::get('sf_images_path').'/'.$this->getOption('loading_image')
           );
  }
  
  /**
   * Fixes a name.
   *  
   * @param  string $name   The name to fix
   * @param  string $suffix The suffix for the name
   * 
   * @return string The fixed name
   */
  public function getFixedName($name, $suffix)
  {
    return ']' == substr($name, -1) ? sprintf('%s_%s]', substr($name, 0, -1), $suffix) : sprintf('%s_%s', $name, $suffix);
  }
  
  /**
   * @see sfWidget
   */
  public function getJavascripts()
  {
    return array('/js/widget/sfWidgetFormAjaxInputFile.js', '/js/jquery/ajaxfileupload.js');
  }
}
