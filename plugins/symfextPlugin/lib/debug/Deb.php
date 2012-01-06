<?php

class Deb
{
  public static function printArray($var, $title = true)
  {
    $string = '<table border = "1">';
    if ($title){
      $string .= "<tr><td><b>Key</b></td><td><b>Value</b></td></tr>\n";
    }
    	
    if (is_array($var)){
      foreach($var as $key => $value){
        $string .= "<tr>\n";
        $string .= "<td><b>$key</b></td><td>";
    		
	    if (is_array($value)){
	      $string .= Deb::printArray($value, false);
	    }else{
	      $string .= '<pre>'.print_r($value, true).'</pre/>';
	    }
	    		
	    $string .= "</td></tr>\n";
      }	
    }else{
      $string .= '<pre>'.print_r($var, true).'</pre/>';
    }
    	
    $string .= "</table>\n";
    
    return $string;
  }
  public static function print_r($var)
  {
    if (sfConfig::get('sf_environment') != 'test' && !sfContext::getInstance()->getRequest()->isXmlHttpRequest())
    {
      print_r(self::printArray($var));
    }
    else
    {
      print_r($var);
    }
    
    die();
  }
  public static function echod($var)
  {
    echo $var;die();
  }
  public static function print_r_pre($var)
  {
  	echo '<pre>';
    print_r(self::printArray($var));
    echo '</pre>';
    //die();
  }
  
  public static function dump($var, $name = 'var', $die = false)
  {
      ob_start();
      print('<br/><pre>'. $name . ' :<br/>');
      print_r($var);
      print('</pre></br>');
      $buffer = ob_get_contents();
      ob_end_clean();
 
      $backtrace = debug_backtrace();
      $dieMsg  = '<pre><b>var dump by goTools:dump()</b>'. "\n";
      $dieMsg .= isset($backtrace[0]['file']) ?     '» file     : <b>'.
      $backtrace[0]['file'] .'</b>'. "\n" : '';
      $dieMsg .= isset($backtrace[0]['line']) ?     '» line     : <b>'.
      $backtrace[0]['line'] .'</b>'. "\n" : '';
      $dieMsg .= isset($backtrace[1]['class']) ?    '» class    : <b>'.
      $backtrace[1]['class'] .'</b>'. "\n" : '';
      $dieMsg .= isset($backtrace[1]['function']) ? '» function : <b>'.
      $backtrace[1]['function'] .'</b>'. "\n" : '';
      $dieMsg .= '</pre>';
      
      print($buffer);
 
      if ($die == true) {
          die($dieMsg);
      } else {
          print($dieMsg);
          sfWebDebug::getInstance()->logShortMessage($buffer);
      }
  }
  
  public static function printRecord($record)
  {
    self::print_r(Doctrine_Lib::getRecordAsString($record));
  }
  public static function printRecord_pre($record)
  {
    self::print_r_pre(Doctrine_Lib::getRecordAsString($record));
  }
  
  public static function printCollection($collection)
  {
    self::print_r(Doctrine_Lib::getCollectionAsString($collection));
  }
  public static function printCollection_pre($collection)
  {
    self::print_r_pre(Doctrine_Lib::getCollectionAsString($collection));
  }
  
  public static function printSql($query)
  {
    print_r(Doctrine_Lib::formatSql($query->getSqlQuery()));
  }
  public static function printSql_pre($query)
  {
    self::print_r_pre(Doctrine_Lib::formatSql($query->getSql()));
  }
  
  public static function printDql($query)
  {
    self::print_r(Doctrine_Lib::formatSql($query->getDql()));
  }
  public static function printDql_pre($query)
  {
    self::print_r_pre(Doctrine_Lib::formatSql($query->getDql()));
  }
  
  public static function printQueryParams(Doctrine_Query_Abstract $query)
  {
    self::print_r($query->getParams());
  }
  public static function printQueryParams_pre(Doctrine_Query_Abstract $query)
  {
    self::print_r_pre($query->getParams());
  }
  
  public static function printToArray($object)
  {
    self::print_r($object->toArray());
  }
  public static function printToArray_pre($object)
  {
    self::print_r_pre($object->toArray());
  }
}
