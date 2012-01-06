<?php

/**
 * Unit test library extended.
 *
 * @package    symfext
 * @subpackage test
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class lime_test_ext extends lime_test
{
  public function isDir($dir, $message = '')
  {
  	if (!$result = $this->ok(is_dir($dir), $message))
  	{
  	  $this->set_last_test_errors(array(sprintf("%s is not a directory", $dir)));
  	}
  	
  	return $result;
  }
  public function isntDir($dir, $message = '')
  {
  	if (!$result = $this->ok(!is_dir($dir), $message))
  	{
  	  $this->set_last_test_errors(array(sprintf("%s is a directory", $dir)));
  	}
  	
  	return $result;
  }
  public function isFile($file, $message = '')
  {
  	if (!$result = $this->ok(is_file($file), $message))
  	{
  	  $this->set_last_test_errors(array(sprintf("%s is not a file", $file)));
  	}
  	
  	return $result;
  }
  public function isntFile($file, $message = '')
  {
  	if (!$result = $this->ok(!is_file($file), $message))
  	{
  	  $this->set_last_test_errors(array(sprintf("%s is a file", $file)));
  	}
  	
  	return $result;
  }
  public function isLink($link, $message = '')
  {
  	if (!$result = $this->ok(is_link($link), $message))
  	{
  	  $this->set_last_test_errors(array(sprintf("%s is not a link", $link)));
  	}
  	
  	return $result;
  }
  public function isntLink($link, $message = '')
  {
  	if (!$result = $this->ok(!is_link($link), $message))
  	{
  	  $this->set_last_test_errors(array(sprintf("%s is a link", $link)));
  	}
  	
  	return $result;
  }
}
