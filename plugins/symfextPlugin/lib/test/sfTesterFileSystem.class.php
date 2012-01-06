<?php

/**
 * sfTesterFileSystem implements tests for the file system related extensions.
 *
 * @package    symfext
 * @subpackage test
 * @author     Jonathan Olger Nieto Lajo <jonathan_nieto@hotmail.com>
 */
class sfTesterFileSystem extends sfTester
{
  public function prepare()
  {
  }

  public function initialize()
  {
  }

  public function isDir($dir, $boolean = true)
  {
    if ($boolean)
    {
      $this->tester->isDir($dir, sprintf("%s is a directory indeed", $dir));
    }
    else
    {
      $this->tester->isntDir($dir, sprintf("%s is not a directory indeed", $dir));
    }
    
    return $this->getObjectToReturn();
  }
  public function isFile($file, $boolean = true)
  {
    if ($boolean)
    {
      $this->tester->isFile($file, sprintf("%s is a file indeed", $file));
    }
    else
    {
      $this->tester->isntFile($file, sprintf("%s is not a file indeed", $file));
    }
    
    return $this->getObjectToReturn();
  }
  public function isLink($link, $boolean = true)
  {
    if ($boolean)
    {
      $this->tester->isLink($link, sprintf("%s is a link indeed", $link));
    }
    else
    {
      $this->tester->isntLink($link, sprintf("%s is not a link indeed", $link));
    }
    
    return $this->getObjectToReturn();
  }
}
