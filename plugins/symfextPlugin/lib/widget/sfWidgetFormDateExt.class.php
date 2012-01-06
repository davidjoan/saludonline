<?php

class sfWidgetFormDateExt extends sfWidgetFormDate
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('year_start', date('Y') - 10);
    $this->addOption('year_end'  , date('Y') + 20);
    
    parent::configure($options, $attributes);
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $this->setOption('days'  , sfContext::getInstance()->getUser()->getDateTimeFormatter()->getDaysArray());
    $this->setOption('months', sfContext::getInstance()->getUser()->getDateTimeFormatter()->getMonthsArray());
    $this->setOption
    (
      'years' , 
      sfContext::getInstance()->getUser()->getDateTimeFormatter()->getYearsArray
      (
        $this->getOption('year_start'),
        $this->getOption('year_end')
      )
    );
    
    $default = array('year' => null, 'month' => null, 'day' => null);
    if (!is_array($value))
    {
      $value = (string) $value == (string) (integer) $value ? (integer) $value : strtotime($value);
      if (false === $value)
      {
        $value = $default;
      }
      else
      {
        $value = array('year' => date('Y', $value), 'month' => date('m', $value), 'day' => date('d', $value));
      }
    }
    
    return parent::render($name, $value, $attributes, $errors);
  }
}
