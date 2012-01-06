<?php

/**
 * sfWidgetFormFormatter
 *
 * @package    symfext
 * @subpackage form
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfWidgetFormFormatter
{
  public function radioFormatter($widget, $inputs)
  {
    $rows  = array();
    $count = 0;
    foreach ($inputs as $input)
    {
      $count++;
      $br = $count % 4 === 0 ? '<br/><br/>' : '';
      $rows[] = $input['input'].$widget->getOption('label_separator').'&nbsp;'.$input['label'].$br;
    }
    
    return implode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $rows);
  }
  public function longRadioFormatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] = $input['input'].$widget->getOption('label_separator').'&nbsp;'.$input['label'];
    }
    
    return implode('<br/>', $rows);
  }
  
  public static function getStandardDateFormat()
  {
    return '%day%&nbsp;-&nbsp;%month%&nbsp;-&nbsp;%year%';
  }
  public static function getShortDateFormat()
  {
    return '%day%-%month%-%year%';
  }
  public function getStandardTimeFormat()
  {
    return '&nbsp;%hour%:%minute%';
  }
  
  public function getInputFileImageTemplate($object, $field)
  {
    if ($object->isNew() || !$object->$field)
    {
      $template = '%input%<br/>%delete% %delete_label%';
    }
    else
    {
      $template = '<a href="%s">%%file%%</a><br />%%input%%<br />%%delete%% %%delete_label%%';
      $template = sprintf($template, $object->getFilePath($field));
    }
    
    return $template;
  }
}
