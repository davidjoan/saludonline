<?php

/**
 * sfDateFormatExt
 *
 * @package    symfext
 * @subpackage i18n
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfDateFormatExt extends sfDateFormat
{
  const
    EXTENDED_CONVERSION_NUMBER = 7000;
  
  public function getCurrentDateTime($format = 'yyyy-MM-dd HH:mm:ss')
  {
    return $this->format(time(), $format);
  }
  public function getDaysArray($from = 1, $to = 31)
  {
    $days = range($from, $to);
    array_walk($days, create_function('&$v, $k', '$v = sprintf("%02d", $v);'));
    
    return array_combine($days, $days);
  }
  public function getMonthsArray($pattern = 'MMM', $from = 1, $to = 12)
  {
    $to++;
    for ($i = $from; $i < $to; $i++)
    {
      $mon = array('mon' => $i);
      $months[$this->getMon($mon, 'MM')] = $this->getMon($mon, $pattern);
    }
    
    return $months;
  }
  public function getYearsArray($from = 2004, $to = null)
  {
    if (is_null($to))
    {
      $to = date('Y');
    }
    
    $years = range($from, $to);
    
    return array_combine($years, $years);
  }
  public function displayExtendedDate($date, $decode = false)
  {
  	$value     = $decode ? self::decodeExtendedDate($date, false) : $date;
  	$firstChar = substr($value, 0, 1);
  	$firstChar = $firstChar == '-' ? $firstChar : '';
  	$value     = substr($value, 0, 1) == '-' ? substr($value, 1, strlen($value)) : $value;
    $date      = explode('-', $value);
    
    $value = preg_replace('/^(\d{1})-/', '000$1-', $value); // TODO for not 2001
    $value = preg_replace('/^(\d{2})-/', '00$1-', $value);  // TODO for not 2012
    $value = preg_replace('/^(\d{3})-/', '0$1-', $value);   // TODO for not error
    //Deb::print_r($value);
    if ($date[1] == '00')
    {
      $value = sprintf('%s%s', $firstChar, $this->format($value, 'yyyy'));
    }
    elseif ($date[2] == '00')
    {
      $value = sprintf('%s %s%s', $this->format($value, 'MMM'), $firstChar, $this->format($value, 'yyyy'));
    }
    else
    {
      $value = sprintf('%s %s%s', $this->format($value, 'dd MMM'), $firstChar, $this->format($value, 'yyyy'));
    }
    
    return $value;
  }
  
  
  public static function encodeExtendedDate($date, $ret_array = false)
  {
    $date = self::convertDateStringToArray($date);
    
    $date['year'] = $date['year'] + self::EXTENDED_CONVERSION_NUMBER;
    
    return !$ret_array ? strtr('year-month-day', $date) : $date;
  }
  public static function decodeExtendedDate($date, $ret_array = false)
  {
    $date = self::convertDateStringToArray($date);
    
    $date['year'] = $date['year'] - self::EXTENDED_CONVERSION_NUMBER;

    return !$ret_array ? strtr('year-month-day', $date) : $date;
  }
  public static function convertDateStringToArray($date)
  {
    if ($date && is_string($date))
    {
      if (preg_match('/(\d+)-(\d{2})-(\d{2})/', $date, $matches))
      {
        $date = array();
        $date['year']  = $matches[1];
        $date['month'] = $matches[2];
        $date['day']   = $matches[3];
      }
    }
    
    return $date;
  }
}
